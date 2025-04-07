<?php

namespace ServNX\Toornament\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use ServNX\Toornament\Exceptions\AuthenticationException;
use ServNX\Toornament\Exceptions\ToornamentException;

class ToornamentClient
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * The OAuth access token.
     *
     * @var string|null
     */
    protected $accessToken;

    /**
     * Create a new Toornament client instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->client = new Client([
            'base_uri' => config('toornament.base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Get the access token for a specific scope.
     *
     * @param string $scope
     * @return string
     * @throws \ServNX\Toornament\Exceptions\AuthenticationException
     */
    public function getAccessToken(string $scope): string
    {
        $cacheKey = "toornament_token_{$scope}";

        return Cache::remember($cacheKey, 3500, function () use ($scope) {
            try {
                $response = (new Client())->post(config('toornament.oauth_token_url'), [
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => config('toornament.oauth.client_id'),
                        'client_secret' => config('toornament.oauth.client_secret'),
                        'scope' => $scope,
                    ],
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                if (isset($data['access_token'])) {
                    return $data['access_token'];
                }

                throw new AuthenticationException('Failed to retrieve access token.');
            } catch (GuzzleException $e) {
                throw new AuthenticationException('OAuth authentication failed: ' . $e->getMessage(), 0, $e);
            }
        });
    }

    /**
     * Make a request to the Toornament API.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $options
     * @param string|null $scope
     * @return array
     * @throws \ServNX\Toornament\Exceptions\ToornamentException
     */
    public function request(string $method, string $endpoint, array $options = [], ?string $scope = null): array
    {
        $headers = [
            'X-Api-Key' => config('toornament.api_key'),
        ];

        if ($scope) {
            $headers['Authorization'] = 'Bearer ' . $this->getAccessToken($scope);
        }

        if (isset($options['headers'])) {
            $headers = array_merge($headers, $options['headers']);
            unset($options['headers']);
        }

        $options['headers'] = $headers;

        try {
            $response = $this->client->request($method, $endpoint, $options);
            $contents = $response->getBody()->getContents();

            return json_decode($contents, true) ?? [];
        } catch (GuzzleException $e) {
            throw new ToornamentException('Toornament API request failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Make a paginated request to the API.
     *
     * @param string $method
     * @param string $endpoint
     * @param string $unit The pagination unit (tournaments, matches, etc.)
     * @param int $size The size of each page
     * @param array $options
     * @param string|null $scope
     * @return array
     */
    public function paginate(string $method, string $endpoint, string $unit, int $size = 50, array $options = [], ?string $scope = null): array
    {
        $result = [];
        $offset = 0;

        do {
            $rangeHeader = "{$unit}={$offset}-" . ($offset + $size - 1);

            $options['headers'] = $options['headers'] ?? [];
            $options['headers']['Range'] = $rangeHeader;

            $response = $this->request($method, $endpoint, $options, $scope);

            if (empty($response)) {
                break;
            }

            $result = array_merge($result, $response);
            $offset += $size;
        } while (count($response) >= $size);

        return $result;
    }
}