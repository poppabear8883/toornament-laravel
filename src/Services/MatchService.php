<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\ToornamentMatch;

class MatchService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'matches';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'matches';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:result';

    /**
     * Get all matches.
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

        $data = $this->client()->paginate('GET', $this->endpoint, $this->unit, 100, $options, $this->getScope());

        return array_map(function ($item) {
            return new ToornamentMatch($item);
        }, $data);
    }

    /**
     * Get a specific match.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\ToornamentMatch
     */
    public function find(string $id): ToornamentMatch
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new ToornamentMatch($data);
    }

    /**
     * Update a match.
     *
     * @param string $id
     * @param array $data
     * @return \ServNX\Toornament\Models\ToornamentMatch
     */
    public function update(string $id, array $data): ToornamentMatch
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            ['json' => $data],
            $this->getScope()
        );

        return new ToornamentMatch($response);
    }

    /**
     * Get matches by tournament.
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
     * Get matches by stage.
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
     * Get matches by group.
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
     * Get matches by round.
     *
     * @param string $roundId
     * @param array $filters Additional filters
     * @return array
     */
    public function byRound(string $roundId, array $filters = []): array
    {
        $filters['round_ids'] = $roundId;

        return $this->all($filters);
    }

    /**
     * Get matches by participant.
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
     * Get matches by status.
     *
     * @param string|array $statuses One of 'pending', 'running', 'completed' or an array
     * @param array $filters Additional filters
     * @return array
     */
    public function byStatus($statuses, array $filters = []): array
    {
        $filters['statuses'] = is_array($statuses)
            ? implode(',', $statuses)
            : $statuses;

        return $this->all($filters);
    }

    /**
     * Get scheduled matches.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function scheduled(array $filters = []): array
    {
        $filters['is_scheduled'] = 1;

        return $this->all($filters);
    }

    /**
     * Get matches scheduled before a specific date.
     *
     * @param string $datetime RFC 3339 format date (e.g., 2023-05-01T00:00:00+00:00)
     * @param array $filters Additional filters
     * @return array
     */
    public function scheduledBefore(string $datetime, array $filters = []): array
    {
        $filters['scheduled_before'] = $datetime;

        return $this->all($filters);
    }

    /**
     * Get matches scheduled after a specific date.
     *
     * @param string $datetime RFC 3339 format date (e.g., 2023-05-01T00:00:00+00:00)
     * @param array $filters Additional filters
     * @return array
     */
    public function scheduledAfter(string $datetime, array $filters = []): array
    {
        $filters['scheduled_after'] = $datetime;

        return $this->all($filters);
    }

    /**
     * Get matches played before a specific date.
     *
     * @param string $datetime RFC 3339 format date (e.g., 2023-05-01T00:00:00+00:00)
     * @param array $filters Additional filters
     * @return array
     */
    public function playedBefore(string $datetime, array $filters = []): array
    {
        $filters['played_before'] = $datetime;

        return $this->all($filters);
    }

    /**
     * Get matches played after a specific date.
     *
     * @param string $datetime RFC 3339 format date (e.g., 2023-05-01T00:00:00+00:00)
     * @param array $filters Additional filters
     * @return array
     */
    public function playedAfter(string $datetime, array $filters = []): array
    {
        $filters['played_after'] = $datetime;

        return $this->all($filters);
    }

    /**
     * Get upcoming matches.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function upcoming(array $filters = []): array
    {
        $filters['statuses'] = 'pending';
        $filters['is_scheduled'] = 1;

        return $this->all($filters);
    }

    /**
     * Get ongoing matches.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function ongoing(array $filters = []): array
    {
        $filters['statuses'] = 'running';

        return $this->all($filters);
    }

    /**
     * Get completed matches.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function completed(array $filters = []): array
    {
        $filters['statuses'] = 'completed';

        return $this->all($filters);
    }

    /**
     * Update a match result.
     *
     * @param string $id
     * @param array $opponents Array of opponent results with their scores
     * @return \ServNX\Toornament\Models\ToornamentMatch
     */
    public function updateResult(string $id, array $opponents): ToornamentMatch
    {
        return $this->update($id, [
            'opponents' => $opponents
        ]);
    }

    /**
     * Set a match schedule.
     *
     * @param string $id
     * @param string $datetime RFC 3339 format date (e.g., 2023-05-01T00:00:00+00:00)
     * @return \ServNX\Toornament\Models\ToornamentMatch
     */
    public function schedule(string $id, string $datetime): ToornamentMatch
    {
        return $this->update($id, [
            'scheduled_datetime' => $datetime
        ]);
    }

    /**
     * Add notes to a match.
     *
     * @param string $id
     * @param string|null $publicNote
     * @param string|null $privateNote
     * @return \ServNX\Toornament\Models\ToornamentMatch
     */
    public function addNotes(string $id, ?string $publicNote = null, ?string $privateNote = null): ToornamentMatch
    {
        $data = [];

        if ($publicNote !== null) {
            $data['public_note'] = $publicNote;
        }

        if ($privateNote !== null) {
            $data['private_note'] = $privateNote;
        }

        return $this->update($id, $data);
    }
}