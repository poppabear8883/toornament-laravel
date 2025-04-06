<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\Discipline;

class DisciplineService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = '/disciplines';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'disciplines';

    /**
     * The required scope.
     * For disciplines, only API key is needed, no OAuth scope required.
     *
     * @var string|null
     */
    protected $scope = null;

    /**
     * Get all disciplines.
     *
     * @return array
     */
    public function all(): array
    {
        $data = $this->client()->paginate('GET', $this->endpoint, $this->unit, 50, [], $this->getScope());

        return array_map(function ($item) {
            return new Discipline($item);
        }, $data);
    }

    /**
     * Get a specific discipline.
     *
     * @param string $id
     * @return \ServNX\Toornament\Models\Discipline
     */
    public function find(string $id): Discipline
    {
        $data = $this->client()->request('GET', "{$this->endpoint}/{$id}", [], $this->getScope());

        return new Discipline($data);
    }

    /**
     * Get a discipline by shortname.
     *
     * @param string $shortname
     * @return \ServNX\Toornament\Models\Discipline|null
     */
    public function findByShortname(string $shortname): ?Discipline
    {
        $disciplines = $this->all();

        foreach ($disciplines as $discipline) {
            if ($discipline->getShortname() === $shortname) {
                return $discipline;
            }
        }

        return null;
    }

    /**
     * Get a discipline by name.
     *
     * @param string $name
     * @return \ServNX\Toornament\Models\Discipline|null
     */
    public function findByName(string $name): ?Discipline
    {
        $disciplines = $this->all();

        foreach ($disciplines as $discipline) {
            if ($discipline->getName() === $name) {
                return $discipline;
            }
        }

        return null;
    }

    /**
     * Get disciplines by platform.
     *
     * @param string $platform
     * @return array
     */
    public function findByPlatform(string $platform): array
    {
        $disciplines = $this->all();
        $results = [];

        foreach ($disciplines as $discipline) {
            $platforms = $discipline->getPlatformsAvailable();

            if (in_array($platform, $platforms)) {
                $results[] = $discipline;
            }
        }

        return $results;
    }
}