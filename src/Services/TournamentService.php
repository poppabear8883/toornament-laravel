<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\Tournament;

class TournamentService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'tournaments';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'tournaments';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:view';

    /**
     * Get all tournaments.
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
            return new Tournament($item);
        }, $data);
    }

    /**
     * Get a specific tournament.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Tournament
     */
    public function find(string $id): Tournament
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new Tournament($data);
    }

    /**
     * Create a new tournament.
     *
     * @param array $data
     * @return \ServNX\Toornament\Models\Tournament
     */
    public function create(array $data): Tournament
    {
        $response = $this->client()->request(
            'POST',
            $this->endpoint,
            ['json' => $data],
            'organizer:admin'
        );

        return new Tournament($response);
    }

    /**
     * Update a tournament.
     *
     * @param string $id
     * @param array $data
     * @return \ServNX\Toornament\Models\Tournament
     */
    public function update(string $id, array $data): Tournament
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            ['json' => $data],
            'organizer:admin'
        );

        return new Tournament($response);
    }

    /**
     * Delete a tournament.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $this->client()->request('DELETE', "{$this->endpoint}/{$id}", [], 'organizer:delete');

        return true;
    }
}