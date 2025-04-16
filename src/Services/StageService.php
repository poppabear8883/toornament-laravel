<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\Stage;

class StageService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'stages';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'stages';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:result';

    /**
     * Get all stages.
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
            return new Stage($item);
        }, $data);
    }

    /**
     * Get a specific stage.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Stage
     */
    public function find(string $id): Stage
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new Stage($data);
    }

    /**
     * Get stages by tournament.
     *
     * @param string $tournamentId
     * @return array
     */
    public function byTournament(string $tournamentId): array
    {
        return $this->all(['tournament_ids' => $tournamentId]);
    }

    /**
     * Create a new stage.
     *
     * @param array $data
     * @return \ServNX\Toornament\Models\Stage
     */
    public function create(array $data): Stage
    {
        $response = $this->client()->request(
            'POST',
            $this->endpoint,
            ['json' => $data],
            'organizer:admin'
        );

        return new Stage($response);
    }

    /**
     * Update a stage.
     *
     * @param string $id
     * @param array $data
     * @return \ServNX\Toornament\Models\Stage
     */
    public function update(string $id, array $data): Stage
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            ['json' => $data],
            'organizer:admin'
        );

        return new Stage($response);
    }

    /**
     * Delete a stage.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $this->client()->request(
            'DELETE',
            "{$this->endpoint}/{$id}",
            [],
            'organizer:admin'
        );

        return true;
    }

    /**
     * Seed participant slots for a stage.
     *
     * @param string $stageId
     * @param array $participantIds
     * @param string $method One of 'standard', 'random', 'manual'
     * @return array
     */
    public function seedParticipants(string $stageId, array $participantIds, string $method = 'manual'): array
    {
        $data = [
            'method' => $method,
            'participant_ids' => $participantIds
        ];

        $response = $this->client()->request(
            'POST',
            "{$this->endpoint}/{$stageId}/participant-slots",
            ['json' => $data],
            'organizer:admin'
        );

        return $response;
    }

    /**
     * Get the stage bracket structure.
     *
     * @param string $stageId
     * @return array
     */
    public function getBracket(string $stageId): array
    {
        // First get the bracket nodes
        $bracketNodes = $this->client()->request('GET', "bracket-nodes", [
            'query' => ['stage_ids' => $stageId]
        ], $this->getScope());

        return $bracketNodes;
    }

    /**
     * Start a stage (change status from 'pending' to 'running').
     *
     * @param string $stageId
     * @return \ServNX\Toornament\Models\Stage
     */
    public function start(string $stageId): Stage
    {
        return $this->update($stageId, [
            'status' => 'running'
        ]);
    }
}