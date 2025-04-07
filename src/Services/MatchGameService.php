<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\MatchGame;

class MatchGameService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'matches/{match_id}/games';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'games';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:result';

    /**
     * Get all games for a match.
     *
     * @param string $matchId
     * @return array
     */
    public function allForMatch(string $matchId): array
    {
        $endpoint = str_replace('{match_id}', $matchId, $this->endpoint);

        $data = $this->client()->paginate('GET', $endpoint, $this->unit, 50, [], $this->getScope());

        return array_map(function ($item) use ($matchId) {
            $item['match_id'] = $matchId; // Add match_id to the game data
            return new MatchGame($item);
        }, $data);
    }

    /**
     * Get a specific game from a match.
     *
     * @param string $matchId
     * @param int $number
     * @return \ServNX\Toornament\Models\MatchGame
     */
    public function find(string $matchId, int $number): MatchGame
    {
        $endpoint = str_replace('{match_id}', $matchId, $this->endpoint) . "/{$number}";

        $data = $this->client()->request('GET', $endpoint, [], $this->getScope());
        $data['match_id'] = $matchId; // Add match_id to the game data

        return new MatchGame($data);
    }

    /**
     * Update a game from a match.
     *
     * @param string $matchId
     * @param int $number
     * @param array $data
     * @return \ServNX\Toornament\Models\MatchGame
     */
    public function update(string $matchId, int $number, array $data): MatchGame
    {
        $endpoint = str_replace('{match_id}', $matchId, $this->endpoint) . "/{$number}";

        $response = $this->client()->request(
            'PATCH',
            $endpoint,
            ['json' => $data],
            $this->getScope()
        );

        $response['match_id'] = $matchId; // Add match_id to the game data

        return new MatchGame($response);
    }

    /**
     * Update the status of a game.
     *
     * @param string $matchId
     * @param int $number
     * @param string|null $status One of 'pending', 'running', 'completed' or null for automatic update
     * @return \ServNX\Toornament\Models\MatchGame
     */
    public function updateStatus(string $matchId, int $number, ?string $status = null): MatchGame
    {
        return $this->update($matchId, $number, [
            'status' => $status
        ]);
    }

    /**
     * Update the result of a game.
     *
     * @param string $matchId
     * @param int $number
     * @param array $opponents
     * @return \ServNX\Toornament\Models\MatchGame
     */
    public function updateResult(string $matchId, int $number, array $opponents): MatchGame
    {
        return $this->update($matchId, $number, [
            'opponents' => $opponents
        ]);
    }

    /**
     * Set a game as completed.
     *
     * @param string $matchId
     * @param int $number
     * @return \ServNX\Toornament\Models\MatchGame
     */
    public function setCompleted(string $matchId, int $number): MatchGame
    {
        return $this->updateStatus($matchId, $number, 'completed');
    }

    /**
     * Set a game as running.
     *
     * @param string $matchId
     * @param int $number
     * @return \ServNX\Toornament\Models\MatchGame
     */
    public function setRunning(string $matchId, int $number): MatchGame
    {
        return $this->updateStatus($matchId, $number, 'running');
    }

    /**
     * Set a game as pending.
     *
     * @param string $matchId
     * @param int $number
     * @return \ServNX\Toornament\Models\MatchGame
     */
    public function setPending(string $matchId, int $number): MatchGame
    {
        return $this->updateStatus($matchId, $number, 'pending');
    }

    /**
     * Update the properties of a game.
     *
     * @param string $matchId
     * @param int $number
     * @param array $properties
     * @return \ServNX\Toornament\Models\MatchGame
     */
    public function updateProperties(string $matchId, int $number, array $properties): MatchGame
    {
        return $this->update($matchId, $number, [
            'properties' => $properties
        ]);
    }

    /**
     * Update the properties of an opponent in a game.
     *
     * @param string $matchId
     * @param int $gameNumber
     * @param int $opponentNumber
     * @param array $properties
     * @return \ServNX\Toornament\Models\MatchGame
     */
    public function updateOpponentProperties(
        string $matchId,
        int $gameNumber,
        int $opponentNumber,
        array $properties
    ): MatchGame {
        // First, get the current game data
        $game = $this->find($matchId, $gameNumber);
        $opponents = $game->getOpponents();

        // Find and update the opponent properties
        foreach ($opponents as $key => $opponent) {
            if ($opponent['number'] === $opponentNumber) {
                $opponents[$key]['properties'] = $properties;
                break;
            }
        }

        // Update the game with the modified opponents
        return $this->update($matchId, $gameNumber, [
            'opponents' => $opponents
        ]);
    }

    /**
     * Get all completed games for a match.
     *
     * @param string $matchId
     * @return array
     */
    public function getCompletedGames(string $matchId): array
    {
        $games = $this->allForMatch($matchId);

        return array_filter($games, function (MatchGame $game) {
            return $game->isCompleted();
        });
    }

    /**
     * Get all pending games for a match.
     *
     * @param string $matchId
     * @return array
     */
    public function getPendingGames(string $matchId): array
    {
        $games = $this->allForMatch($matchId);

        return array_filter($games, function (MatchGame $game) {
            return $game->isPending();
        });
    }

    /**
     * Get all running games for a match.
     *
     * @param string $matchId
     * @return array
     */
    public function getRunningGames(string $matchId): array
    {
        $games = $this->allForMatch($matchId);

        return array_filter($games, function (MatchGame $game) {
            return $game->isRunning();
        });
    }
}