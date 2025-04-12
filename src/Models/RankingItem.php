<?php

namespace ServNX\Toornament\Models;

class RankingItem implements \JsonSerializable
{
    /**
     * The ranking item attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new ranking item instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the ranking item ID.
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
     * Get the number.
     *
     * @return int
     */
    public function getNumber(): int
    {
        return (int) $this->attributes['number'];
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
     * Get the rank.
     *
     * @return int|null
     */
    public function getRank(): ?int
    {
        return $this->attributes['rank'] !== null ? (int) $this->attributes['rank'] : null;
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
     * Get the points.
     *
     * @return int
     */
    public function getPoints(): int
    {
        return (int) $this->attributes['points'];
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
     * Get the wins.
     *
     * @return int
     */
    public function getWins(): int
    {
        return (int) $this->getProperty('wins', 0);
    }

    /**
     * Get the draws.
     *
     * @return int
     */
    public function getDraws(): int
    {
        return (int) $this->getProperty('draws', 0);
    }

    /**
     * Get the losses.
     *
     * @return int
     */
    public function getLosses(): int
    {
        return (int) $this->getProperty('losses', 0);
    }

    /**
     * Get the played count.
     *
     * @return int
     */
    public function getPlayed(): int
    {
        return (int) $this->getProperty('played', 0);
    }

    /**
     * Get the forfeits count.
     *
     * @return int
     */
    public function getForfeits(): int
    {
        return (int) $this->getProperty('forfeits', 0);
    }

    /**
     * Get the score for (only for ranking items with score).
     *
     * @return int|null
     */
    public function getScoreFor(): ?int
    {
        $scoreFor = $this->getProperty('score_for');

        return $scoreFor !== null ? (int) $scoreFor : null;
    }

    /**
     * Get the score against (only for ranking items with score).
     *
     * @return int|null
     */
    public function getScoreAgainst(): ?int
    {
        $scoreAgainst = $this->getProperty('score_against');

        return $scoreAgainst !== null ? (int) $scoreAgainst : null;
    }

    /**
     * Get the score difference (only for ranking items with score).
     *
     * @return int|null
     */
    public function getScoreDifference(): ?int
    {
        $scoreDifference = $this->getProperty('score_difference');

        return $scoreDifference !== null ? (int) $scoreDifference : null;
    }

    /**
     * Get match history (only for Swiss format).
     *
     * @return string|null
     */
    public function getMatchHistory(): ?string
    {
        return $this->getProperty('match_history');
    }

    /**
     * Check if participant is dropped (only for Swiss format).
     *
     * @return bool|null
     */
    public function isDropped(): ?bool
    {
        $dropped = $this->getProperty('dropped');

        return $dropped !== null ? (bool) $dropped : null;
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
     * Get all ranking item attributes.
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