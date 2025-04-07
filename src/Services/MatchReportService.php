<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\MatchReport;

class MatchReportService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'reports';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'reports';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:result';

    /**
     * Get all match reports.
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
            return new MatchReport($item);
        }, $data);
    }

    /**
     * Get a specific match report.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\MatchReport
     */
    public function find(string $id): MatchReport
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new MatchReport($data);
    }

    /**
     * Create a new match report.
     *
     * @param array $data
     * @return \ServNX\Toornament\Models\MatchReport
     */
    public function create(array $data): MatchReport
    {
        $response = $this->client()->request(
            'POST',
            $this->endpoint,
            ['json' => $data],
            $this->getScope()
        );

        return new MatchReport($response);
    }

    /**
     * Update a match report.
     *
     * @param string $id
     * @param array $data
     * @return \ServNX\Toornament\Models\MatchReport
     */
    public function update(string $id, array $data): MatchReport
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            ['json' => $data],
            $this->getScope()
        );

        return new MatchReport($response);
    }

    /**
     * Get match reports by tournament.
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
     * Get match reports by match.
     *
     * @param string $matchId
     * @param array $filters Additional filters
     * @return array
     */
    public function byMatch(string $matchId, array $filters = []): array
    {
        $filters['match_ids'] = $matchId;

        return $this->all($filters);
    }

    /**
     * Get match reports by participant.
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
     * Get match reports by user.
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
     * Get match reports by team.
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
     * Get match reports by custom user identifier.
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
     * Get match reports by type.
     *
     * @param string|array $types One of 'report', 'dispute' or an array
     * @param array $filters Additional filters
     * @return array
     */
    public function byType($types, array $filters = []): array
    {
        $filters['types'] = is_array($types)
            ? implode(',', $types)
            : $types;

        return $this->all($filters);
    }

    /**
     * Get closed match reports.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function closed(array $filters = []): array
    {
        $filters['is_closed'] = 1;

        return $this->all($filters);
    }

    /**
     * Get open match reports.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function open(array $filters = []): array
    {
        $filters['is_closed'] = 0;

        return $this->all($filters);
    }

    /**
     * Get report-type match reports.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function reports(array $filters = []): array
    {
        return $this->byType('report', $filters);
    }

    /**
     * Get dispute-type match reports.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function disputes(array $filters = []): array
    {
        return $this->byType('dispute', $filters);
    }

    /**
     * Create a report for a match.
     *
     * @param string $matchId
     * @param string $participantId
     * @param array $opponents
     * @param string|null $note
     * @param string|null $userId
     * @param string|null $customUserIdentifier
     * @return \ServNX\Toornament\Models\MatchReport
     */
    public function createReport(
        string $matchId,
        string $participantId,
        array $opponents,
        ?string $note = null,
        ?string $userId = null,
        ?string $customUserIdentifier = null
    ): MatchReport {
        $data = [
            'match_id' => $matchId,
            'participant_id' => $participantId,
            'type' => 'report',
            'report' => [
                'opponents' => $opponents
            ]
        ];

        if ($note !== null) {
            $data['note'] = $note;
        }

        if ($userId !== null) {
            $data['user_id'] = $userId;
        }

        if ($customUserIdentifier !== null) {
            $data['custom_user_identifier'] = $customUserIdentifier;
        }

        return $this->create($data);
    }

    /**
     * Create a dispute for a match.
     *
     * @param string $matchId
     * @param string $participantId
     * @param array $opponents
     * @param string|null $note
     * @param string|null $userId
     * @param string|null $customUserIdentifier
     * @return \ServNX\Toornament\Models\MatchReport
     */
    public function createDispute(
        string $matchId,
        string $participantId,
        array $opponents,
        ?string $note = null,
        ?string $userId = null,
        ?string $customUserIdentifier = null
    ): MatchReport {
        $data = [
            'match_id' => $matchId,
            'participant_id' => $participantId,
            'type' => 'dispute',
            'report' => [
                'opponents' => $opponents
            ]
        ];

        if ($note !== null) {
            $data['note'] = $note;
        }

        if ($userId !== null) {
            $data['user_id'] = $userId;
        }

        if ($customUserIdentifier !== null) {
            $data['custom_user_identifier'] = $customUserIdentifier;
        }

        return $this->create($data);
    }

    /**
     * Close a match report.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\MatchReport
     */
    public function close(string $id): MatchReport
    {
        return $this->update($id, [
            'closed' => true
        ]);
    }

    /**
     * Add a note to a match report.
     *
     * @param string $id
     * @param string $note
     * @return \ServNX\Toornament\Models\MatchReport
     */
    public function addNote(string $id, string $note): MatchReport
    {
        return $this->update($id, [
            'note' => $note
        ]);
    }
}