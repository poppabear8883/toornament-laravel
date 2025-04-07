<?php

namespace ServNX\Toornament\Models;

class Tournament implements \JsonSerializable
{
    /**
     * The tournament attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new tournament instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the tournament ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the tournament name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Get the tournament discipline.
     *
     * @return string
     */
    public function getDiscipline(): string
    {
        return $this->attributes['discipline'];
    }

    /**
     * Get the tournament status.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    /**
     * Check if the tournament is public.
     *
     * @return bool
     */
    public function isPublic(): bool
    {
        return (bool) $this->attributes['public'];
    }

    /**
     * Get the tournament size.
     *
     * @return int
     */
    public function getSize(): int
    {
        return (int) $this->attributes['size'];
    }

    /**
     * Get the tournament start date.
     *
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->attributes['scheduled_date_start'] ?? null;
    }

    /**
     * Get the tournament end date.
     *
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->attributes['scheduled_date_end'] ?? null;
    }

    /**
     * Get all tournament attributes.
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