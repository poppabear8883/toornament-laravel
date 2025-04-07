<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\Sponsor;

class SponsorService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'tournament-sponsors';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'sponsors';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:admin';

    /**
     * Get all sponsors.
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
            return new Sponsor($item);
        }, $data);
    }

    /**
     * Get a specific sponsor.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Sponsor
     */
    public function find(string $id): Sponsor
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new Sponsor($data);
    }

    /**
     * Create a new sponsor.
     *
     * @param array $data
     * @return \ServNX\Toornament\Models\Sponsor
     */
    public function create(array $data): Sponsor
    {
        $response = $this->client()->request(
            'POST',
            $this->endpoint,
            ['json' => $data],
            $this->getScope()
        );

        return new Sponsor($response);
    }

    /**
     * Update a sponsor.
     *
     * @param string $id
     * @param array $data
     * @return \ServNX\Toornament\Models\Sponsor
     */
    public function update(string $id, array $data): Sponsor
    {
        $response = $this->client()->request(
            'PATCH',
            "{$this->endpoint}/{$id}",
            ['json' => $data],
            $this->getScope()
        );

        return new Sponsor($response);
    }

    /**
     * Delete a sponsor.
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
     * Get sponsors by tournament.
     *
     * @param string $tournamentId
     * @return array
     */
    public function byTournament(string $tournamentId): array
    {
        return $this->all(['tournament_ids' => $tournamentId]);
    }

    /**
     * Create a new sponsor for a tournament.
     *
     * @param string $tournamentId
     * @param string $name
     * @param string $logoId
     * @param string|null $website
     * @param int $position
     * @return \ServNX\Toornament\Models\Sponsor
     */
    public function createForTournament(
        string $tournamentId,
        string $name,
        string $logoId,
        ?string $website = null,
        int $position = 0
    ): Sponsor {
        $data = [
            'tournament_id' => $tournamentId,
            'name' => $name,
            'website' => $website,
            'position' => $position,
            'light_logo' => [
                'id' => $logoId
            ]
        ];

        return $this->create($data);
    }

    /**
     * Update sponsor name.
     *
     * @param string $id
     * @param string $name
     * @return \ServNX\Toornament\Models\Sponsor
     */
    public function updateName(string $id, string $name): Sponsor
    {
        return $this->update($id, [
            'name' => $name
        ]);
    }

    /**
     * Update sponsor website.
     *
     * @param string $id
     * @param string|null $website
     * @return \ServNX\Toornament\Models\Sponsor
     */
    public function updateWebsite(string $id, ?string $website = null): Sponsor
    {
        return $this->update($id, [
            'website' => $website
        ]);
    }

    /**
     * Update sponsor position.
     *
     * @param string $id
     * @param int $position
     * @return \ServNX\Toornament\Models\Sponsor
     */
    public function updatePosition(string $id, int $position): Sponsor
    {
        return $this->update($id, [
            'position' => $position
        ]);
    }

    /**
     * Update sponsor logo.
     *
     * @param string $id
     * @param string $logoId
     * @return \ServNX\Toornament\Models\Sponsor
     */
    public function updateLogo(string $id, string $logoId): Sponsor
    {
        return $this->update($id, [
            'light_logo' => [
                'id' => $logoId
            ]
        ]);
    }

    /**
     * Reorder sponsors.
     *
     * @param array $sponsorIds Ordered array of sponsor IDs
     * @return bool
     */
    public function reorder(array $sponsorIds): bool
    {
        $position = 0;

        foreach ($sponsorIds as $sponsorId) {
            $this->updatePosition($sponsorId, $position);
            $position++;
        }

        return true;
    }
}