<?php

namespace ServNX\Toornament\Services;

use ServNX\Toornament\Models\Placement;

class PlacementService extends BaseToornamentService
{
    /**
     * The base API endpoint.
     *
     * @var string
     */
    protected $endpoint = 'stages';

    /**
     * The required scope.
     *
     * @var string
     */
    protected $scope = 'organizer:placement';

    /**
     * Get all placement slots for a stage.
     *
     * @param string $stageId
     * @return array
     */
    public function all(string $stageId): array
    {
        $data = $this->client()->request(
            'GET',
            "{$this->endpoint}/{$stageId}/placement-slots",
            [],
            $this->getScope()
        );

        return array_map(function ($item) {
            return new Placement($item);
        }, $data);
    }

    /**
     * Update placement slots for a stage.
     *
     * @param string $stageId
     * @param array $slots Array of slot data containing 'number' and 'participant_id'
     * @return array
     */
    public function update(string $stageId, array $slots): array
    {
        $data = $this->client()->request(
            'PUT',
            "{$this->endpoint}/{$stageId}/placement-slots",
            ['json' => $slots],
            $this->getScope()
        );

        return array_map(function ($item) {
            return new Placement($item);
        }, $data);
    }

    /**
     * Reset all placement slots for a stage.
     *
     * @param string $stageId
     * @return bool
     */
    public function reset(string $stageId): bool
    {
        $this->client()->request(
            'DELETE',
            "{$this->endpoint}/{$stageId}/placement-slots",
            [],
            $this->getScope()
        );

        return true;
    }

    /**
     * Update a single placement slot.
     *
     * @param string $stageId
     * @param int $slotNumber
     * @param string|null $participantId
     * @return Placement
     */
    public function updateSlot(string $stageId, int $slotNumber, ?string $participantId): Placement
    {
        // Get all current slots
        $slots = $this->all($stageId);
        
        // Find and update the specific slot
        $updated = false;
        foreach ($slots as $i => $slot) {
            if ($slot->getNumber() === $slotNumber) {
                $slots[$i] = [
                    'number' => $slotNumber,
                    'participant_id' => $participantId
                ];
                $updated = true;
                break;
            }
        }

        // If slot not found, add it
        if (!$updated) {
            $slots[] = [
                'number' => $slotNumber,
                'participant_id' => $participantId
            ];
        }

        // Convert Placement objects back to arrays
        $slotsData = array_map(function ($slot) {
            if ($slot instanceof Placement) {
                return [
                    'number' => $slot->getNumber(),
                    'participant_id' => $slot->getParticipantId()
                ];
            }
            return $slot;
        }, $slots);

        // Update all slots
        $result = $this->update($stageId, $slotsData);

        // Find and return the updated slot
        foreach ($result as $slot) {
            if ($slot->getNumber() === $slotNumber) {
                return $slot;
            }
        }

        // This shouldn't happen, but return the first slot if not found
        return $result[0];
    }
}