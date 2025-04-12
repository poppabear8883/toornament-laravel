<?php

namespace ServNX\Toornament\Models;

class MatchGame implements \JsonSerializable
{
    /**
     * The match game attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new match game instance.
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
    public function getMatchId(): string
    {
        return $this->attributes['match_id'];
    }

    /**
     * Get the game number.
     *
     * @return int
     */
    public function getNumber(): int
    {
        return (int) $this->attributes['number'];
    }

    /**
     * Get the game status.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    /**
     * Get the opponents.
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
     * Get the properties.
     *
     * @return array
     */
    public function getProperties(): array
    {
        return $this->attributes['properties'] ?? [];
    }

    /**
     * Get a property value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getProperty(string $key, $default = null)
    {
        $properties = $this->getProperties();

        return $properties[$key] ?? $default;
    }

    /**
     * Get opponent properties.
     *
     * @param int $opponentNumber
     * @return array
     */
    public function getOpponentProperties(int $opponentNumber): array
    {
        $opponent = $this->getOpponent($opponentNumber);

        return $opponent['properties'] ?? [];
    }

    /**
     * Get an opponent property value by key.
     *
     * @param int $opponentNumber
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getOpponentProperty(int $opponentNumber, string $key, $default = null)
    {
        $properties = $this->getOpponentProperties($opponentNumber);

        return $properties[$key] ?? $default;
    }

    /**
     * Get the winner of the game.
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
     * Get the loser of the game.
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
     * Check if the game is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->getStatus() === 'completed';
    }

    /**
     * Check if the game is running.
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->getStatus() === 'running';
    }

    /**
     * Check if the game is pending.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->getStatus() === 'pending';
    }

    /**
     * Get all match game attributes.
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