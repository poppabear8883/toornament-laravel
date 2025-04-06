<?php

namespace ServNX\Toornament\Models;

class MatchReport
{
    /**
     * The match report attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new match report instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the match report ID.
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
     * Get the match ID.
     *
     * @return string
     */
    public function getMatchId(): string
    {
        return $this->attributes['match_id'];
    }

    /**
     * Get the participant ID.
     *
     * @return string
     */
    public function getParticipantId(): string
    {
        return $this->attributes['participant_id'];
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
     * Get the custom user identifier.
     *
     * @return string|null
     */
    public function getCustomUserIdentifier(): ?string
    {
        return $this->attributes['custom_user_identifier'] ?? null;
    }

    /**
     * Get the report type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->attributes['type'];
    }

    /**
     * Check if the report is closed.
     *
     * @return bool
     */
    public function isClosed(): bool
    {
        return (bool) $this->attributes['closed'];
    }

    /**
     * Get the closed date.
     *
     * @return string|null
     */
    public function getClosedAt(): ?string
    {
        return $this->attributes['closed_at'] ?? null;
    }

    /**
     * Get the closed author ID.
     *
     * @return string|null
     */
    public function getClosedAuthorId(): ?string
    {
        return $this->attributes['closed_author_id'] ?? null;
    }

    /**
     * Get the note.
     *
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->attributes['note'] ?? null;
    }

    /**
     * Get the report data.
     *
     * @return array
     */
    public function getReport(): array
    {
        return $this->attributes['report'] ?? [];
    }

    /**
     * Get the opponents data from the report.
     *
     * @return array
     */
    public function getOpponents(): array
    {
        $report = $this->getReport();

        return $report['opponents'] ?? [];
    }

    /**
     * Get the proofs.
     *
     * @return array
     */
    public function getProofs(): array
    {
        return $this->attributes['proofs'] ?? [];
    }

    /**
     * Check if this is a report.
     *
     * @return bool
     */
    public function isReport(): bool
    {
        return $this->getType() === 'report';
    }

    /**
     * Check if this is a dispute.
     *
     * @return bool
     */
    public function isDispute(): bool
    {
        return $this->getType() === 'dispute';
    }

    /**
     * Check if this report has a note.
     *
     * @return bool
     */
    public function hasNote(): bool
    {
        return !empty($this->getNote());
    }

    /**
     * Check if this report has proofs.
     *
     * @return bool
     */
    public function hasProofs(): bool
    {
        return !empty($this->getProofs());
    }

    /**
     * Get all match report attributes.
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