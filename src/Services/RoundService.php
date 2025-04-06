<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\Round;

class RoundService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = '/rounds';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'rounds';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:result';

    /**
     * Get all rounds.
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
            return new Round($item);
        }, $data);
    }

    /**
     * Get a specific round.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Round
     */
    public function find(string $id): Round
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new Round($data);
    }

    /**
     * Get rounds by tournament.
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
     * Get rounds by stage.
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
     * Get rounds by stage number.
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
     * Get rounds by group.
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
     * Get rounds by group number.
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
     * Get tournament rounds by stage and group.
     *
     * @param string $tournamentId
     * @param string $stageId
     * @param string $groupId
     * @param array $filters Additional filters
     * @return array
     */
    public function byTournamentStageAndGroup(
        string $tournamentId,
        string $stageId,
        string $groupId,
        array $filters = []
    ): array {
        $filters['tournament_ids'] = $tournamentId;
        $filters['stage_ids'] = $stageId;
        $filters['group_ids'] = $groupId;

        return $this->all($filters);
    }

    /**
     * Get rounds by number.
     *
     * @param int $roundNumber
     * @param array $filters Additional filters
     * @return array
     */
    public function byNumber(int $roundNumber, array $filters = []): array
    {
        // Filter rounds to get only those with the specified number
        return array_filter($this->all($filters), function (Round $round) use ($roundNumber) {
            return $round->getNumber() === $roundNumber;
        });
    }

    /**
     * Get open rounds.
     *
     * @param array $filters
     * @return array
     */
    public function open(array $filters = []): array
    {
        // Filter rounds to get only those that are not closed
        return array_filter($this->all($filters), function (Round $round) {
            return !$round->isClosed();
        });
    }

    /**
     * Get closed rounds.
     *
     * @param array $filters
     * @return array
     */
    public function closed(array $filters = []): array
    {
        // Filter rounds to get only those that are closed
        return array_filter($this->all($filters), function (Round $round) {
            return $round->isClosed();
        });
    }

    /**
     * Get the settings for a round.
     *
     * @param \ServNX\Toornament\Models\Round $round
     * @return array
     */
    public function getSettings(Round $round): array
    {
        return $round->getSettings();
    }

    /**
     * Get the match settings for a round.
     *
     * @param \ServNX\Toornament\Models\Round $round
     * @return array
     */
    public function getMatchSettings(Round $round): array
    {
        return $round->getMatchSettings();
    }

    /**
     * Get the match format for a round.
     *
     * @param \ServNX\Toornament\Models\Round $round
     * @return array|null
     */
    public function getMatchFormat(Round $round): ?array
    {
        $matchSettings = $round->getMatchSettings();

        return $matchSettings['format'] ?? null;
    }
}