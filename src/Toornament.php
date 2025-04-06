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