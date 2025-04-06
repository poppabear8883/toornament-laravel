<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\CustomField;

class CustomFieldService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = '/custom-fields';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'custom-fields';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:admin';

    /**
     * Get all custom fields.
     *
     * @param string $targetType One of 'player', 'team', 'team_player'
     * @param array $filters Additional filters
     * @return array
     */
    public function all(string $targetType, array $filters = []): array
    {
        $options = [
            'query' => array_merge(['target_type' => $targetType], $filters)
        ];

        $data = $this->client()->paginate('GET', $this->endpoint, $this->unit, 50, $options, $this->getScope());

        return array_map(function ($item) {
            return new CustomField($item);
        }, $data);
    }

    /**
     * Get a specific custom field.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function find(string $id): CustomField
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new CustomField($data);
    }

    /**
     * Create a new custom field.
     *
     * @param array $data
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function create(array $data): CustomField
    {
        $response = $this->client()->request(
            'POST',
            $this->endpoint,
            ['json' => $data],
            $this->getScope()
        );

        return new CustomField($response);
    }

    /**
     * Update a custom field.
     *
     * @param string $id
     * @param array $data
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function update(string $id, array $data): CustomField
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            ['json' => $data],
            $this->getScope()
        );

        return new CustomField($response);
    }

    /**
     * Delete a custom field.
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
     * Get custom fields by tournament.
     *
     * @param string $tournamentId
     * @param string $targetType One of 'player', 'team', 'team_player'
     * @return array
     */
    public function byTournament(string $tournamentId, string $targetType): array
    {
        return $this->all($targetType, ['tournament_ids' => $tournamentId]);
    }

    /**
     * Get player custom fields.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function playerFields(array $filters = []): array
    {
        return $this->all('player', $filters);
    }

    /**
     * Get team custom fields.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function teamFields(array $filters = []): array
    {
        return $this->all('team', $filters);
    }

    /**
     * Get team player custom fields.
     *
     * @param array $filters Additional filters
     * @return array
     */
    public function teamPlayerFields(array $filters = []): array
    {
        return $this->all('team_player', $filters);
    }

    /**
     * Create a new player custom field.
     *
     * @param string $tournamentId
     * @param string $machineName
     * @param string $label
     * @param string $type
     * @param array $additionalData
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function createPlayerField(
        string $tournamentId,
        string $machineName,
        string $label,
        string $type,
        array $additionalData = []
    ): CustomField {
        $data = array_merge([
            'tournament_id' => $tournamentId,
            'machine_name' => $machineName,
            'label' => $label,
            'type' => $type,
            'target_type' => 'player',
            'required' => false,
            'public' => false,
            'position' => 0,
            'default_value' => null,
            'options' => (object) []
        ], $additionalData);

        return $this->create($data);
    }

    /**
     * Create a new team custom field.
     *
     * @param string $tournamentId
     * @param string $machineName
     * @param string $label
     * @param string $type
     * @param array $additionalData
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function createTeamField(
        string $tournamentId,
        string $machineName,
        string $label,
        string $type,
        array $additionalData = []
    ): CustomField {
        $data = array_merge([
            'tournament_id' => $tournamentId,
            'machine_name' => $machineName,
            'label' => $label,
            'type' => $type,
            'target_type' => 'team',
            'required' => false,
            'public' => false,
            'position' => 0,
            'default_value' => null,
            'options' => (object) []
        ], $additionalData);

        return $this->create($data);
    }

    /**
     * Create a new team player custom field.
     *
     * @param string $tournamentId
     * @param string $machineName
     * @param string $label
     * @param string $type
     * @param array $additionalData
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function createTeamPlayerField(
        string $tournamentId,
        string $machineName,
        string $label,
        string $type,
        array $additionalData = []
    ): CustomField {
        $data = array_merge([
            'tournament_id' => $tournamentId,
            'machine_name' => $machineName,
            'label' => $label,
            'type' => $type,
            'target_type' => 'team_player',
            'required' => false,
            'public' => false,
            'position' => 0,
            'default_value' => null,
            'options' => (object) []
        ], $additionalData);

        return $this->create($data);
    }

    /**
     * Set field visibility.
     *
     * @param string $id
     * @param bool $isPublic
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function setVisibility(string $id, bool $isPublic): CustomField
    {
        return $this->update($id, [
            'public' => $isPublic
        ]);
    }

    /**
     * Set field requirement.
     *
     * @param string $id
     * @param bool $isRequired
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function setRequired(string $id, bool $isRequired): CustomField
    {
        return $this->update($id, [
            'required' => $isRequired
        ]);
    }

    /**
     * Set field position.
     *
     * @param string $id
     * @param int $position
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function setPosition(string $id, int $position): CustomField
    {
        return $this->update($id, [
            'position' => $position
        ]);
    }

    /**
     * Set field default value.
     *
     * @param string $id
     * @param mixed $defaultValue
     * @return \ServNX\Toornament\Models\CustomField
     */
    public function setDefaultValue(string $id, $defaultValue): CustomField
    {
        return $this->update($id, [
            'default_value' => $defaultValue
        ]);
    }
}