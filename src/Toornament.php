<?php

namespace ServNX\Toornament;

use ServNX\Toornament\Http\ToornamentClient;

class Toornament
{
    /**
     * The Toornament HTTP client.
     *
     * @var \ServNX\Toornament\Http\ToornamentClient
     */
    protected $client;

    /**
     * Create a new Toornament instance.
     *
     * @param \ServNX\Toornament\Http\ToornamentClient $client
     */
    public function __construct(ToornamentClient $client)
    {
        $this->client = $client;
    }

    /**
     * Dynamically handle calls to services.
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        if (app()->bound("toornament.{$method}")) {
            return app("toornament.{$method}");
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    /**
     * Get the HTTP client instance.
     *
     * @return \ServNX\Toornament\Http\ToornamentClient
     */
    public function getClient(): ToornamentClient
    {
        return $this->client;
    }

    /**
     * Get a service by name.
     *
     * @param string $name
     * @return mixed
     */
    public function service(string $name)
    {
        return app("toornament.{$name}");
    }

    /**
     * Dynamically access services.
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->service($name);
    }
}