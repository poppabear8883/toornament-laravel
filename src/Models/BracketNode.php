<?php

namespace ServNX\Toornament\Models;

class BracketNode
{
    /**
     * The bracket node attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new bracket node instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the bracket node ID.
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
     * @return string
     */
    public function getRoundId(): string
    {
        return $this->attributes['round_id'];
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
     * Get the node type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->attributes['type'];
    }

    /**
     * Get the node status.
     *
     * @return string
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
     * Get the node depth.
     *
     * @return int
     */
    public function getDepth(): int
    {
        return (int) $this->attributes['depth'];
    }

    /**
     * Get the node branch.
     *
     * @return string|null
     */
    public function getBranch(): ?string
    {
        return $this->attributes['branch'] ?? null;
    }

    /**
     * Get the node opponents.
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
     * Get the loser of the match.
     *
     * @return array|null
     */
    public function getLoser(): ?array
    {
        foreach ($this->getOpponents() as $opponent) {
            if (isset($opponent['result']) && $opponent['result'] === 'loss') {
                return $opponent;
            }
        }

        return null;
    }

    /**
     * Check if the node is in winners bracket.
     *
     * @return bool
     */
    public function isInWinnersBracket(): bool
    {
        return $this->getBranch() === 'wb';
    }

    /**
     * Check if the node is in losers bracket.
     *
     * @return bool
     */
    public function isInLosersBracket(): bool
    {
        return $this->getBranch() === 'lb';
    }

    /**
     * Check if the node is in grand final.
     *
     * @return bool
     */
    public function isInGrandFinal(): bool
    {
        return $this->getBranch() === 'gf';
    }

    /**
     * Check if the node is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->getStatus() === 'completed';
    }

    /**
     * Check if the node is running.
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->getStatus() === 'running';
    }

    /**
     * Check if the node is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->getStatus() === 'pending';
    }

    /**
     * Get all bracket node attributes.
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