<?php

namespace ServNX\Toornament\Models;

class Webhook implements \JsonSerializable
{
    /**
     * The webhook attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new webhook instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the webhook ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the webhook name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Get the webhook URL.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->attributes['url'];
    }

    /**
     * Check if the webhook is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool) $this->attributes['enabled'];
    }

    /**
     * Get all webhook attributes.
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