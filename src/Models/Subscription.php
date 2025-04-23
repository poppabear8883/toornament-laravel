<?php

namespace ServNX\Toornament\Models;

class Subscription implements \JsonSerializable
{
    /**
     * The subscription attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new subscription instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the subscription ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the event name.
     *
     * @return string
     */
    public function getEventName(): string
    {
        return $this->attributes['event_name'];
    }

    /**
     * Get the scope.
     *
     * @return string
     */
    public function getScope(): string
    {
        return $this->attributes['scope'];
    }

    /**
     * Get the scope ID.
     *
     * @return string
     */
    public function getScopeId(): string
    {
        return $this->attributes['scope_id'];
    }

    /**
     * Get all subscription attributes.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function jsonSerialize(): array
    {
        return $this->attributes;
    }
}