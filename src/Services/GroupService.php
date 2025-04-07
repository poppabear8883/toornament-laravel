<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\Group;

class GroupService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'groups';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'groups';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:result';

    /**
     * Get all groups.
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
            return new Group($item);
        }, $data);
    }

    /**
     * Get a specific group.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Group
     */
    public function find(string $id): Group
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new Group($data);
    }

    /**
     * Get groups by tournament.
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
     * Get groups by stage.
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
     * Get groups by stage number.
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
     * Get tournament groups by stage.
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
     * Get groups by number.
     *
     * @param int $groupNumber
     * @param array $filters Additional filters
     * @return array
     */
    public function byNumber(int $groupNumber, array $filters = []): array
    {
        // Filter groups to get only those with the specified number
        return array_filter($this->all($filters), function (Group $group) use ($groupNumber) {
            return $group->getNumber() === $groupNumber;
        });
    }

    /**
     * Get open groups.
     *
     * @param array $filters
     * @return array
     */
    public function open(array $filters = []): array
    {
        // Filter groups to get only those that are not closed
        return array_filter($this->all($filters), function (Group $group) {
            return !$group->isClosed();
        });
    }

    /**
     * Get closed groups.
     *
     * @param array $filters
     * @return array
     */
    public function closed(array $filters = []): array
    {
        // Filter groups to get only those that are closed
        return array_filter($this->all($filters), function (Group $group) {
            return $group->isClosed();
        });
    }

    /**
     * Get the settings for a group.
     *
     * @param \ServNX\Toornament\Models\Group $group
     * @return array
     */
    public function getSettings(Group $group): array
    {
        return $group->getSettings();
    }

    /**
     * Get the match settings for a group.
     *
     * @param \ServNX\Toornament\Models\Group $group
     * @return array
     */
    public function getMatchSettings(Group $group): array
    {
        return $group->getMatchSettings();
    }

    /**
     * Get the match format for a group.
     *
     * @param \ServNX\Toornament\Models\Group $group
     * @return array|null
     */
    public function getMatchFormat(Group $group): ?array
    {
        $matchSettings = $group->getMatchSettings();

        return $matchSettings['format'] ?? null;
    }
}