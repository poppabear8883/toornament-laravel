<?php

namespace ServNX\Toornament\Models;

class StandingItem implements \JsonSerializable
{
    /**
     * The standing item attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new standing item instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the standing item ID.
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
     * Get the participant.
     *
     * @return array|null
     */
    public function getParticipant(): ?array
    {
        return $this->attributes['participant'] ?? null;
    }

    /**
     * Get the participant ID.
     *
     * @return string|null
     */
    public function getParticipantId(): ?string
    {
        return $this->attributes['participant']['id'] ?? null;
    }

    /**
     * Get the participant name.
     *
     * @return string|null
     */
    public function getParticipantName(): ?string
    {
        return $this->attributes['participant']['name'] ?? null;
    }

    /**
     * Get the rank.
     *
     * @return int
     */
    public function getRank(): int
    {
        return (int) $this->attributes['rank'];
    }

    /**
     * Get the position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return (int) $this->attributes['position'];
    }

    /**
     * Check if this is tied with other participants.
     *
     * @param array $standingItems
     * @return bool
     */
    public function isTied(array $standingItems): bool
    {
        $rank = $this->getRank();

        foreach ($standingItems as $item) {
            if ($item->getId() !== $this->getId() && $item->getRank() === $rank) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get participant's custom user identifier.
     *
     * @return string|null
     */
    public function getCustomUserIdentifier(): ?string
    {
        return $this->attributes['participant']['custom_user_identifier'] ?? null;
    }

    /**
     * Get participant's custom fields.
     *
     * @return array
     */
    public function getCustomFields(): array
    {
        return $this->attributes['participant']['custom_fields'] ?? [];
    }

    /**
     * Get all standing item attributes.
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