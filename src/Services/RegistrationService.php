<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\Registration;

class RegistrationService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'registrations';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'registrations';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:registration';

    /**
     * Get all registrations.
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
            return new Registration($item);
        }, $data);
    }

    /**
     * Get a specific registration.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Registration
     */
    public function find(string $id): Registration
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new Registration($data);
    }

    /**
     * Create a new registration.
     *
     * @param array $data
     * @param bool $ignoreRequiredFields
     * @return \ServNX\Toornament\Models\Registration
     */
    public function create(array $data, bool $ignoreRequiredFields = false): Registration
    {
        $options = [
            'json' => $data
        ];

        if ($ignoreRequiredFields) {
            $options['query'] = ['custom_field_required' => 0];
        }

        $response = $this->client()->request(
            'POST',
            $this->endpoint,
            $options,
            $this->getScope()
        );

        return new Registration($response);
    }

    /**
     * Update a registration.
     *
     * @param string $id
     * @param array $data
     * @param bool $ignoreRequiredFields
     * @return \ServNX\Toornament\Models\Registration
     */
    public function update(string $id, array $data, bool $ignoreRequiredFields = false): Registration
    {
        $options = [
            'json' => $data
        ];

        if ($ignoreRequiredFields) {
            $options['query'] = ['custom_field_required' => 0];
        }

        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            $options,
            $this->getScope()
        );

        return new Registration($response);
    }

    /**
     * Delete a registration.
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
     * Get registrations by tournament.
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
     * Get registrations by status.
     *
     * @param string|array $statuses One of 'pending', 'accepted', 'refused', 'cancelled' or an array
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
     * Get pending registrations.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function pending(array $filters = []): array
    {
        return $this->byStatus('pending', $filters);
    }

    /**
     * Get accepted registrations.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function accepted(array $filters = []): array
    {
        return $this->byStatus('accepted', $filters);
    }

    /**
     * Get refused registrations.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function refused(array $filters = []): array
    {
        return $this->byStatus('refused', $filters);
    }

    /**
     * Get cancelled registrations.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function cancelled(array $filters = []): array
    {
        return $this->byStatus('cancelled', $filters);
    }

    /**
     * Get registrations by user.
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
     * Get registrations by team.
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
     * Get registrations by custom user identifier.
     *
     * @param string $customIdentifier
     * @param array $filters Additional filters
     * @return array
     */
    public function byCustomUserIdentifier(string $customIdentifier, array $filters = []): array
    {
        $filters['custom_user_identifiers'] = $customIdentifier;

        return $this->all($filters);
    }

    /**
     * Accept a registration.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Registration
     */
    public function accept(string $id): Registration
    {
        return $this->update($id, [
            'status' => 'accepted'
        ]);
    }

    /**
     * Refuse a registration.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Registration
     */
    public function refuse(string $id): Registration
    {
        return $this->update($id, [
            'status' => 'refused'
        ]);
    }

    /**
     * Cancel a registration.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Registration
     */
    public function cancel(string $id): Registration
    {
        return $this->update($id, [
            'status' => 'cancelled'
        ]);
    }

    /**
     * Create a player registration.
     *
     * @param array $data
     * @param bool $ignoreRequiredFields
     * @return \ServNX\Toornament\Models\Registration
     */
    public function createPlayerRegistration(array $data, bool $ignoreRequiredFields = false): Registration
    {
        $data['type'] = 'player';

        return $this->create($data, $ignoreRequiredFields);
    }

    /**
     * Create a team registration.
     *
     * @param array $data
     * @param bool $ignoreRequiredFields
     * @return \ServNX\Toornament\Models\Registration
     */
    public function createTeamRegistration(array $data, bool $ignoreRequiredFields = false): Registration
    {
        $data['type'] = 'team';

        return $this->create($data, $ignoreRequiredFields);
    }
}