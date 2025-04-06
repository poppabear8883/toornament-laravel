<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\BracketNode;

class BracketService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = '/bracket-nodes';

    /**
     * The pagination unit.
     *
     * @var string
     */
    protected $unit = 'nodes';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:result';

    /**
     * Get all bracket nodes.
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

        $data = $this->client()->paginate('GET', $this->endpoint, $this->unit, 128, $options, $this->getScope());

        return array_map(function ($item) {
            return new BracketNode($item);
        }, $data);
    }

    /**
     * Get bracket nodes by tournament.
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
     * Get bracket nodes by stage.
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
     * Get bracket nodes by group.
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
     * Get bracket nodes by round.
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
     * Get bracket nodes by depth.
     *
     * @param int $depth
     * @param array $filters Additional filters
     * @return array
     */
    public function byDepth(int $depth, array $filters = []): array
    {
        $filters['min_depth'] = $depth;
        $filters['max_depth'] = $depth;

        return $this->all($filters);
    }

    /**
     * Get bracket nodes by depth range.
     *
     * @param int $minDepth
     * @param int $maxDepth
     * @param array $filters Additional filters
     * @return array
     */
    public function byDepthRange(int $minDepth, int $maxDepth, array $filters = []): array
    {
        $filters['min_depth'] = $minDepth;
        $filters['max_depth'] = $maxDepth;

        return $this->all($filters);
    }

    /**
     * Get bracket nodes by tournament and stage.
     *
     * @param string $tournamentId
     * @param string $stageId
     * @param array $filters Additional filters
     * @return array
     */
    public function byTournamentAndStage(string $tournamentId, string $stageId, array $filters = []): array
    {
        $filters['tournament_ids'] = $tournamentId;
        $filters['stage_ids'] = $stageId;

        return $this->all($filters);
    }

    /**
     * Get bracket nodes in winners' bracket.
     *
     * @param array $filters
     * @return array
     */
    public function inWinnersBracket(array $filters = []): array
    {
        // Filter nodes to get only the ones in winners' bracket
        return array_filter($this->all($filters), function (BracketNode $node) {
            return $node->getBranch() === 'wb';
        });
    }

    /**
     * Get bracket nodes in losers' bracket.
     *
     * @param array $filters
     * @return array
     */
    public function inLosersBracket(array $filters = []): array
    {
        // Filter nodes to get only the ones in losers' bracket
        return array_filter($this->all($filters), function (BracketNode $node) {
            return $node->getBranch() === 'lb';
        });
    }

    /**
     * Get bracket nodes in grand final.
     *
     * @param array $filters
     * @return array
     */
    public function inGrandFinal(array $filters = []): array
    {
        // Filter nodes to get only the ones in grand final
        return array_filter($this->all($filters), function (BracketNode $node) {
            return $node->getBranch() === 'gf';
        });
    }

    /**
     * Get final bracket node.
     *
     * @param string $tournamentId
     * @param string $stageId
     * @return \ServNX\Toornament\Models\BracketNode|null
     */
    public function getFinal(string $tournamentId, string $stageId): ?BracketNode
    {
        $filters = [
            'tournament_ids' => $tournamentId,
            'stage_ids' => $stageId,
            'min_depth' => 0,
            'max_depth' => 0
        ];

        $finals = $this->all($filters);

        return !empty($finals) ? $finals[0] : null;
    }

    /**
     * Get source nodes for a specific node.
     *
     * @param \ServNX\Toornament\Models\BracketNode $node
     * @return array
     */
    public function getSourceNodes(BracketNode $node): array
    {
        $sourceNodes = [];
        $opponents = $node->getOpponents();

        foreach ($opponents as $opponent) {
            if (isset($opponent['source_node_id']) && $opponent['source_node_id'] !== null) {
                $filters = [
                    'tournament_ids' => $node->getTournamentId(),
                    'stage_ids' => $node->getStageId()
                ];

                $allNodes = $this->all($filters);

                foreach ($allNodes as $potentialSourceNode) {
                    if ($potentialSourceNode->getId() === $opponent['source_node_id']) {
                        $sourceNodes[] = [
                            'type' => $opponent['source_type'], // 'winner' or 'loser'
                            'opponent_number' => $opponent['number'],
                            'node' => $potentialSourceNode
                        ];
                        break;
                    }
                }
            }
        }

        return $sourceNodes;
    }

    /**
     * Build a complete bracket structure.
     *
     * @param string $tournamentId
     * @param string $stageId
     * @return array Hierarchical structure of the bracket
     */
    public function buildBracketStructure(string $tournamentId, string $stageId): array
    {
        $filters = [
            'tournament_ids' => $tournamentId,
            'stage_ids' => $stageId
        ];

        // Get all nodes for this bracket
        $allNodes = $this->all($filters);

        // Find the root node (depth 0)
        $rootNodes = array_filter($allNodes, function (BracketNode $node) {
            return $node->getDepth() === 0;
        });

        if (empty($rootNodes)) {
            return [];
        }

        $rootNode = reset($rootNodes);
        $structure = $this->buildNodeStructure($rootNode, $allNodes);

        return $structure;
    }

    /**
     * Build node structure recursively.
     *
     * @param \ServNX\Toornament\Models\BracketNode $node
     * @param array $allNodes
     * @return array
     */
    protected function buildNodeStructure(BracketNode $node, array $allNodes): array
    {
        $structure = [
            'node' => $node,
            'children' => []
        ];

        foreach ($node->getOpponents() as $opponent) {
            if (isset($opponent['source_node_id']) && $opponent['source_node_id'] !== null) {
                // Find the source node
                foreach ($allNodes as $potentialSourceNode) {
                    if ($potentialSourceNode->getId() === $opponent['source_node_id']) {
                        $structure['children'][] = [
                            'type' => $opponent['source_type'], // 'winner' or 'loser'
                            'opponent_number' => $opponent['number'],
                            'structure' => $this->buildNodeStructure($potentialSourceNode, $allNodes)
                        ];
                        break;
                    }
                }
            }
        }

        return $structure;
    }
}