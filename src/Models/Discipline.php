<?php

namespace ServNX\Toornament\Models;

class Discipline implements \JsonSerializable
{
    /**
     * The discipline attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new discipline instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the discipline ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the discipline name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Get the discipline shortname.
     *
     * @return string
     */
    public function getShortname(): string
    {
        return $this->attributes['shortname'];
    }

    /**
     * Get the discipline fullname.
     *
     * @return string
     */
    public function getFullname(): string
    {
        return $this->attributes['fullname'];
    }

    /**
     * Get the discipline copyrights.
     *
     * @return string
     */
    public function getCopyrights(): string
    {
        return $this->attributes['copyrights'];
    }

    /**
     * Get available platforms for this discipline.
     * Only available in detailed view.
     *
     * @return array
     */
    public function getPlatformsAvailable(): array
    {
        return $this->attributes['platforms_available'] ?? [];
    }

    /**
     * Get team size information.
     * Only available in detailed view.
     *
     * @return array|null
     */
    public function getTeamSize(): ?array
    {
        return $this->attributes['team_size'] ?? null;
    }

    /**
     * Get the minimum team size.
     * Only available in detailed view.
     *
     * @return int|null
     */
    public function getMinTeamSize(): ?int
    {
        return $this->attributes['team_size']['min'] ?? null;
    }

    /**
     * Get the maximum team size.
     * Only available in detailed view.
     *
     * @return int|null
     */
    public function getMaxTeamSize(): ?int
    {
        return $this->attributes['team_size']['max'] ?? null;
    }

    /**
     * Get the discipline features.
     * Only available in detailed view.
     *
     * @return array
     */
    public function getFeatures(): array
    {
        return $this->attributes['features'] ?? [];
    }

    /**
     * Check if this discipline has a specific feature.
     *
     * @param string $featureName
     * @return bool
     */
    public function hasFeature(string $featureName): bool
    {
        if (!isset($this->attributes['features'])) {
            return false;
        }

        foreach ($this->attributes['features'] as $feature) {
            if ($feature['name'] === $featureName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a specific feature.
     *
     * @param string $featureName
     * @return array|null
     */
    public function getFeature(string $featureName): ?array
    {
        if (!isset($this->attributes['features'])) {
            return null;
        }

        foreach ($this->attributes['features'] as $feature) {
            if ($feature['name'] === $featureName) {
                return $feature;
            }
        }

        return null;
    }

    /**
     * Get all discipline attributes.
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

    public function jsonSerialize()
    {
        return $this->attributes;
    }
}