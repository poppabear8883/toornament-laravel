<?php

namespace ServNX\Toornament\Models;

class ToornamentMatch
{
    /**
     * The match attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new match instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the match ID.
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
     * Get the group ID.
     *
     * @return string
     */
    public function getGroupId(): string
    {
        return $this->attributes['group_id'];
    }

    /**
     * Get the round ID.
     *
     * @return string|null
     */
    public function getRoundId(): ?string
    {
        return $this->attributes['round_id'] ?? null;
    }

    /**
     * Get the match number.
     *
     * @return int
     */
    public function getNumber(): int
    {
        return (int) $this->attributes['number'];
    }

    /**
     * Get the match type.
     *
     * @return string One of 'duel', 'ffa', 'bye'
     */
    public function getType(): string
    {
        return $this->attributes['type'];
    }

    /**
     * Get the match status.
     *
     * @return string One of 'pending', 'running', 'completed'
     */
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    /**
     * Get the scheduled datetime.
     *
     * @return string|null
     */
    public function getScheduledDatetime(): ?string
    {
        return $this->attributes['scheduled_datetime'] ?? null;
    }

    /**
     * Get the played datetime.
     *
     * @return string|null
     */
    public function getPlayedAt(): ?string
    {
        return $this->attributes['played_at'] ?? null;
    }

    /**
     * Check if the match report is closed.
     *
     * @return bool
     */
    public function isReportClosed(): bool
    {
        return (bool) $this->attributes['report_closed'];
    }

    /**
     * Get the report status.
     *
     * @return string|null
     */
    public function getReportStatus(): ?string
    {
        return $this->attributes['report_status'] ?? null;
    }

    /**
     * Get the public note.
     *
     * @return string|null
     */
    public function getPublicNote(): ?string
    {
        return $this->attributes['public_note'] ?? null;
    }

    /**
     * Get the private note.
     *
     * @return string|null
     */
    public function getPrivateNote(): ?string
    {
        return $this->attributes['private_note'] ?? null;
    }

    /**
     * Get the match settings.
     *
     * @return array
     */
    public function getSettings(): array
    {
        return $this->attributes['settings'] ?? [];
    }

    /**
     * Get the match opponents.
     *
     * @return array
     */
    public function getOpponents(): array
    {
        return $this->attributes['opponents'] ?? [];
    }

    /**
     * Get an opponent by number.
     *
     * @param int $number
     * @return array|null
     */
    public function getOpponent(int $number): ?array
    {
        foreach ($this->getOpponents() as $opponent) {
            if ($opponent['number'] === $number) {
                return $opponent;
            }
        }

        return null;
    }

    /**
     * Get the winner of the match.
     *
     * @return array|null
     */
    public function getWinner(): ?array
    {
        foreach ($this->getOpponents() as $opponent) {
            if (isset($opponent['result']) && $opponent['result'] === 'win') {
                return $opponent;
            }
        }

        return null;
    }

    /**
     * Check if the match is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->getStatus() === 'completed';
    }

    /**
     * Check if the match is running.
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->getStatus() === 'running';
    }

    /**
     * Check if the match is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->getStatus() === 'pending';
    }

    /**
     * Check if the match is scheduled.
     *
     * @return bool
     */
    public function isScheduled(): bool
    {
        return $this->getScheduledDatetime() !== null;
    }

    /**
     * Check if the match has been played.
     *
     * @return bool
     */
    public function hasBeenPlayed(): bool
    {
        return $this->getPlayedAt() !== null;
    }

    /**
     * Get all match attributes.
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