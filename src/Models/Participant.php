<?php

namespace ServNX\Toornament\Models;

class Participant
{
    /**
     * The participant attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new participant instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the participant ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the participant name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Get the participant type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->attributes['type'];
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
     * Check if the participant is checked in.
     *
     * @return bool
     */
    public function isCheckedIn(): bool
    {
        return (bool) $this->attributes['checked_in'];
    }

    /**
     * Get the participant custom fields.
     *
     * @return array
     */
    public function getCustomFields(): array
    {
        return $this->attributes['custom_fields'] ?? [];
    }

    /**
     * Get all participant attributes.
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