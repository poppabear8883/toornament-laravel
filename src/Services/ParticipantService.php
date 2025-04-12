<?php

namespace ServNX\Toornament\Services;

use Illuminate\Support\Collection;
use ServNX\Toornament\Models\Participant;

class ParticipantService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'participants';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'participants';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:participant';

    /**
     * Get all participants.
     *
     * @param array $filters
     * @return array
     */
    public function all(array $filters = []): Collection
    {
        $options = [];

        if (!empty($filters)) {
            $options['query'] = $filters;
        }

        $data = $this->client()->paginate('GET', $this->endpoint, $this->unit, 50, $options, $this->getScope());

        return collect(array_map(function ($item) {
            return new Participant($item);
        }, $data));
    }

    /**
     * Get a specific participant.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Participant
     */
    public function find(string $id): Participant
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new Participant($data);
    }

    /**
     * Create a new participant.
     *
     * @param array $data
     * @return \ServNX\Toornament\Models\Participant
     */
    public function create(array $data): Participant
    {
        $response = $this->client()->request(
            'POST',
            $this->endpoint,
            ['json' => $data],
            $this->getScope()
        );

        return new Participant($response);
    }

    /**
     * Update a participant.
     *
     * @param string $id
     * @param array $data
     * @return \ServNX\Toornament\Models\Participant
     */
    public function update(string $id, array $data): Participant
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            ['json' => $data],
            $this->getScope()
        );

        return new Participant($response);
    }

    /**
     * Delete a participant.
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $this->client()->request('DELETE', "{$this->endpoint}/{$id}", [], $this->getScope());

        return true;
    }
}