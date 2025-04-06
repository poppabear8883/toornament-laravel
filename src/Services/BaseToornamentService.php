<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Toornament;

abstract class BaseToornamentService
{
    /**
     * The Toornament instance.
     *
     * @var \ServNX\Toornament\Toornament
     */
    protected $toornament;

    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit;

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope;

    /**
     * Create a new service instance.
     *
     * @param \ServNX\Toornament\Toornament $toornament
     */
    public function __construct(Toornament $toornament)
    {
        $this->toornament = $toornament;
    }

    /**
     * Get the HTTP client instance.
     *
     * @return \ServNX\Toornament\Http\ToornamentClient
     */
    protected function client()
    {
        return $this->toornament->getClient();
    }

    /**
     * Get the required OAuth scope for this service.
     *
     * @return string|null
     */
    protected function getScope(): ?string
    {
        return $this->scope;
    }
}