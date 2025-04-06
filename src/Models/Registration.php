<?php

namespace ServNX\Toornament\Models;

class Registration
{
    /**
     * The registration attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new registration instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the registration ID.
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
     * Get the participant ID.
     *
     * @return string|null
     */
    public function getParticipantId(): ?string
    {
        return $this->attributes['participant_id'] ?? null;
    }

    /**
     * Get the user ID.
     *
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->attributes['user_id'] ?? null;
    }

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Get the email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->attributes['email'] ?? null;
    }

    /**
     * Get the custom user identifier.
     *
     * @return string|null
     */
    public function getCustomUserIdentifier(): ?string
    {
        return $this->attributes['custom_user_identifier'] ?? null;
    }

    /**
     * Get the type.
     *
     * @return string 'team' or 'player'
     */
    public function getType(): string
    {
        return $this->attributes['type'];
    }

    /**
     * Get the status.
     *
     * @return string 'pending', 'accepted', 'refused', or 'cancelled'
     */
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    /**
     * Get the created date.
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    /**
     * Get the country.
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->attributes['country'] ?? null;
    }

    /**
     * Get the birth date.
     *
     * @return string|null
     */
    public function getBirthDate(): ?string
    {
        return $this->attributes['birth_date'] ?? null;
    }

    /**
     * Get the custom fields.
     *
     * @return array
     */
    public function getCustomFields(): array
    {
        return $this->attributes['custom_fields'] ?? [];
    }

    /**
     * Get the properties.
     *
     * @return array
     */
    public function getProperties(): array
    {
        return $this->attributes['properties'] ?? [];
    }

    /**
     * Get the lineup (team registrations only).
     *
     * @return array
     */
    public function getLineup(): array
    {
        return $this->attributes['lineup'] ?? [];
    }

    /**
     * Check if this is a player registration.
     *
     * @return bool
     */
    public function isPlayer(): bool
    {
        return $this->getType() === 'player';
    }

    /**
     * Check if this is a team registration.
     *
     * @return bool
     */
    public function isTeam(): bool
    {
        return $this->getType() === 'team';
    }

    /**
     * Check if this registration is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->getStatus() === 'pending';
    }

    /**
     * Check if this registration is accepted.
     *
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->getStatus() === 'accepted';
    }

    /**
     * Check if this registration is refused.
     *
     * @return bool
     */
    public function isRefused(): bool
    {
        return $this->getStatus() === 'refused';
    }

    /**
     * Check if this registration is cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->getStatus() === 'cancelled';
    }

    /**
     * Get all registration attributes.
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