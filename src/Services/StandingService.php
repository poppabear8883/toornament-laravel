<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\StandingItem;

class StandingService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = '/standing-items';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'items';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:result';

    /**
     * Get all standing items.
     *
     * @param array $filters
     * @return array
     */
    public function all(array $filters = []): array
    {
        $options = [];

        if (!empty($filters)) {
            $options['query'] = $filters;
        }

        $data = $this->client()->paginate('GET', $this->endpoint, $this->unit, 50, $options, $this->getScope());

        return array_map(function ($item) {
            return new StandingItem($item);
        }, $data);
    }

    /**
     * Get a specific standing item.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\StandingItem
     */
    public function find(string $id): StandingItem
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new StandingItem($data);
    }

    /**
     * Create a new standing item.
     *
     * @param array $data
     * @return \ServNX\Toornament\Models\StandingItem
     */
    public function create(array $data): StandingItem
    {
        $response = $this->client()->request(
            'POST',
            $this->endpoint,
            ['json' => $data],
            $this->getScope()
        );

        return new StandingItem($response);
    }

    /**
     * Update a standing item.
     *
     * @param string $id
     * @param array $data
     * @return \ServNX\Toornament\Models\StandingItem
     */
    public function update(string $id, array $data): StandingItem
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            ['json' => $data],
            $this->getScope()
        );

        return new StandingItem($response);
    }

    /**
     * Delete a standing item.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $this->client()->request('DELETE', "{$this->endpoint}/{$id}", [], $this->getScope());

        return true;
    }

    /**
     * Get standing items by tournament.
     *
     * @param string $tournamentId
     * @param array $filters Additional filters
     * @return array
     */
    public function byTournament(string $tournamentId, array $filters = []): array
    {
        $filters['tournament_ids'] = $tournamentId;

        return $this->all($filters);
    }

    /**
     * Get standing items by participant.
     *
     * @param string $participantId
     * @param array $filters Additional filters
     * @return array
     */
    public function byParticipant(string $participantId, array $filters = []): array
    {
        $filters['participant_ids'] = $participantId;

        return $this->all($filters);
    }

    /**
     * Get standing items by user.
     *
     * @param string $userId
     * @param array $filters Additional filters
     * @return array
     */
    public function byUser(string $userId, array $filters = []): array
    {
        $filters['user_ids'] = $userId;

        return $this->all($filters);
    }

    /**
     * Get standing items by team.
     *
     * @param string $teamId
     * @param array $filters Additional filters
     * @return array
     */
    public function byTeam(string $teamId, array $filters = []): array
    {
        $filters['team_ids'] = $teamId;

        return $this->all($filters);
    }

    /**
     * Get standing items by custom user identifier.
     *
     * @param string $customUserIdentifier
     * @param array $filters Additional filters
     * @return array
     */
    public function byCustomUserIdentifier(string $customUserIdentifier, array $filters = []): array
    {
        $filters['custom_user_identifiers'] = $customUserIdentifier;

        return $this->all($filters);
    }

    /**
     * Get standing items by rank range.
     *
     * @param int $minRank
     * @param int $maxRank
     * @param array $filters Additional filters
     * @return array
     */
    public function byRankRange(int $minRank, int $maxRank, array $filters = []): array
    {
        $filters['min_rank'] = $minRank;
        $filters['max_rank'] = $maxRank;

        return $this->all($filters);
    }

    /**
     * Create a standing item for a tournament and participant.
     *
     * @param string $tournamentId
     * @param string $participantId
     * @param int $rank
     * @return \ServNX\Toornament\Models\StandingItem
     */
    public function createForParticipant(
        string $tournamentId,
        string $participantId,
        int $rank
    ): StandingItem {
        $data = [
            'tournament_id' => $tournamentId,
            'participant_id' => $participantId,
            'rank' => $rank
        ];

        return $this->create($data);
    }

    /**
     * Update a standing item's rank.
     *
     * @param string $id
     * @param int $rank
     * @return \ServNX\Toornament\Models\StandingItem
     */
    public function updateRank(string $id, int $rank): StandingItem
    {
        return $this->update($id, [
            'rank' => $rank
        ]);
    }

    /**
     * Get the top N ranked participants.
     *
     * @param string $tournamentId
     * @param int $count
     * @return array
     */
    public function getTopRanked(string $tournamentId, int $count = 3): array
    {
        $standings = $this->byTournament($tournamentId);

        // Sort by position
        usort($standings, function (StandingItem $a, StandingItem $b) {
            return $a->getPosition() <=> $b->getPosition();
        });

        // Take only the requested number of items
        return array_slice($standings, 0, $count);
    }
}