<?php

namespace ServNX\Toornament\Models;

class Sponsor
{
    /**
     * The sponsor attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new sponsor instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the sponsor ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the tournament ID.
     *
     * @return string
     */
    public function getTournamentId(): string
    {
        return $this->attributes['tournament_id'];
    }

    /**
     * Get the sponsor name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Get the sponsor website.
     *
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->attributes['website'];
    }

    /**
     * Get the sponsor position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return (int) $this->attributes['position'];
    }

    /**
     * Get the sponsor logo.
     *
     * @return array|null
     */
    public function getLogo(): ?array
    {
        return $this->attributes['light_logo'] ?? null;
    }

    /**
     * Get the sponsor logo ID.
     *
     * @return string|null
     */
    public function getLogoId(): ?string
    {
        return $this->attributes['light_logo']['id'] ?? null;
    }

    /**
     * Check if the sponsor has a website.
     *
     * @return bool
     */
    public function hasWebsite(): bool
    {
        return !empty($this->getWebsite());
    }

    /**
     * Check if the sponsor has a logo.
     *
     * @return bool
     */
    public function hasLogo(): bool
    {
        return !empty($this->getLogo());
    }

    /**
     * Get all sponsor attributes.
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
}