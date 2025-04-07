<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\RankingItem;

class RankingService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'ranking-items';

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
     * Get all ranking items.
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
            return new RankingItem($item);
        }, $data);
    }

    /**
     * Get ranking items by tournament.
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
     * Get ranking items by stage.
     *
     * @param string $stageId
     * @param array $filters Additional filters
     * @return array
     */
    public function byStage(string $stageId, array $filters = []): array
    {
        $filters['stage_ids'] = $stageId;

        return $this->all($filters);
    }

    /**
     * Get ranking items by stage number.
     *
     * @param int $stageNumber
     * @param array $filters Additional filters
     * @return array
     */
    public function byStageNumber(int $stageNumber, array $filters = []): array
    {
        $filters['stage_numbers'] = $stageNumber;

        return $this->all($filters);
    }

    /**
     * Get ranking items by group.
     *
     * @param string $groupId
     * @param array $filters Additional filters
     * @return array
     */
    public function byGroup(string $groupId, array $filters = []): array
    {
        $filters['group_ids'] = $groupId;

        return $this->all($filters);
    }

    /**
     * Get ranking items by group number.
     *
     * @param int $groupNumber
     * @param array $filters Additional filters
     * @return array
     */
    public function byGroupNumber(int $groupNumber, array $filters = []): array
    {
        $filters['group_numbers'] = $groupNumber;

        return $this->all($filters);
    }

    /**
     * Get ranking items by participant.
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
     * Get ranking items by user.
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
     * Get ranking items by team.
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
     * Get ranking items by custom user identifier.
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
     * Get ranking items by rank range.
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
     * Get ranking items for a tournament stage.
     *
     * @param string $tournamentId
     * @param string $stageId
     * @param array $filters Additional filters
     * @return array
     */
    public function byTournamentAndStage(string $tournamentId, string $stageId, array $filters = []): array
    {
        $filters['tournament_ids'] = $tournamentId;
        $filters['stage_ids'] = $stageId;

        return $this->all($filters);
    }

    /**
     * Get ranking items for a tournament group.
     *
     * @param string $tournamentId
     * @param string $groupId
     * @param array $filters Additional filters
     * @return array
     */
    public function byTournamentAndGroup(string $tournamentId, string $groupId, array $filters = []): array
    {
        $filters['tournament_ids'] = $tournamentId;
        $filters['group_ids'] = $groupId;

        return $this->all($filters);
    }

    /**
     * Get the top N ranked participants.
     *
     * @param array $filters
     * @param int $count
     * @return array
     */
    public function getTopRanked(array $filters, int $count = 3): array
    {
        $rankings = $this->all($filters);

        // Sort by position
        usort($rankings, function (RankingItem $a, RankingItem $b) {
            return $a->getPosition() <=> $b->getPosition();
        });

        // Take only the requested number of items
        return array_slice($rankings, 0, $count);
    }

    /**
     * Get the top N ranked participants in a tournament.
     *
     * @param string $tournamentId
     * @param int $count
     * @return array
     */
    public function getTopRankedInTournament(string $tournamentId, int $count = 3): array
    {
        return $this->getTopRanked(['tournament_ids' => $tournamentId], $count);
    }

    /**
     * Get the top N ranked participants in a tournament stage.
     *
     * @param string $tournamentId
     * @param string $stageId
     * @param int $count
     * @return array
     */
    public function getTopRankedInStage(string $tournamentId, string $stageId, int $count = 3): array
    {
        return $this->getTopRanked([
            'tournament_ids' => $tournamentId,
            'stage_ids' => $stageId
        ], $count);
    }

    /**
     * Get the top N ranked participants in a tournament group.
     *
     * @param string $tournamentId
     * @param string $groupId
     * @param int $count
     * @return array
     */
    public function getTopRankedInGroup(string $tournamentId, string $groupId, int $count = 3): array
    {
        return $this->getTopRanked([
            'tournament_ids' => $tournamentId,
            'group_ids' => $groupId
        ], $count);
    }
}