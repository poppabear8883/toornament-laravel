<?php

namespace ServNX\Toornament\Models;

class Group
{
    /**
     * The group attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new group instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the group ID.
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
     * Get the stage ID.
     *
     * @return string
     */
    public function getStageId(): string
    {
        return $this->attributes['stage_id'];
    }

    /**
     * Get the group number.
     *
     * @return int
     */
    public function getNumber(): int
    {
        return (int) $this->attributes['number'];
    }

    /**
     * Get the group name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Check if the group is closed.
     *
     * @return bool
     */
    public function isClosed(): bool
    {
        return (bool) $this->attributes['closed'];
    }

    /**
     * Get the group settings.
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
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getSetting(string $key, $default = null)
    {
        $settings = $this->getSettings();

        return $settings[$key] ?? $default;
    }

    /**
     * Get a match setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getMatchSetting(string $key, $default = null)
    {
        $matchSettings = $this->getMatchSettings();

        return $matchSettings[$key] ?? $default;
    }

    /**
     * Get pairing values for the group.
     *
     * @return array
     */
    public function getPairingValues(): array
    {
        $settings = $this->getSettings();

        return $settings['pairing_values'] ?? [];
    }

    /**
     * Get all group attributes.
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