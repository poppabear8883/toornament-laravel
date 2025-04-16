<?php

namespace ServNX\Toornament\Models;

class Stage implements \JsonSerializable
{
    /**
     * The stage attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new stage instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the stage ID.
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
     * Get the stage number.
     *
     * @return int
     */
    public function getNumber(): int
    {
        return (int) $this->attributes['number'];
    }

    /**
     * Get the stage name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Get the stage type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->attributes['type'];
    }

    /**
     * Get the stage status.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    /**
     * Check if the stage is closed.
     *
     * @return bool
     */
    public function isClosed(): bool
    {
        return (bool) $this->attributes['closed'];
    }

    /**
     * Get the stage settings.
     *
     * @return array
     */
    public function getSettings(): array
    {
        return $this->attributes['settings'] ?? [];
    }

    /**
     * Get the match settings.
     *
     * @return array
     */
    public function getMatchSettings(): array
    {
        return $this->attributes['match_settings'] ?? [];
    }

    /**
     * Check if auto placement is enabled.
     *
     * @return bool
     */
    public function isAutoPlacementEnabled(): bool
    {
        return (bool) ($this->attributes['auto_placement_enabled'] ?? false);
    }

    /**
     * Get all stage attributes.
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