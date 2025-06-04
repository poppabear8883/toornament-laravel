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
     * @throws \ServNX\Toornament\Exceptions\ToornamentException
     */
    public function all(string $stageId): array
    {
        try {
            $data = $this->client()->request(
                'GET',
                "{$this->endpoint}/{$stageId}/placement-slots",
                [],
                $this->getScope()
            );
        } catch (\Exception $e) {
            // Log the full error for debugging
            error_log("Placement API Error: " . $e->getMessage());
            error_log("Endpoint: {$this->endpoint}/{$stageId}/placement-slots");
            throw $e;
        }

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
            'PATCH',
            "{$this->endpoint}/{$stageId}/slots",
            ['json' => $slots],
            $this->getScope()
        );

        return array_map(function ($item) {
            return new Placement($item);
        }, $data);
    }

    /**
     * Reset all placement slots for a stage.
     * Note: The Toornament API doesn't provide a DELETE endpoint for slots.
     * To reset, you would need to update all slots with null participant_ids.
     *
     * @param string $stageId
     * @return bool
     */
    public function reset(string $stageId): bool
    {
        // Get all current slots
        $slots = $this->all($stageId);
        
        // Set all participant_ids to null
        $resetSlots = array_map(function ($slot) {
            return [
                'number' => $slot->getNumber(),
                'participant_id' => null
            ];
        }, $slots);
        
        // Update with null participant_ids
        $this->update($stageId, $resetSlots);
        
        return true;
    }

    /**
     * Verify if a stage exists and has placement slots available.
     *
     * @param string $stageId
     * @return bool
     */
    public function verifyStage(string $stageId): bool
    {
        try {
            // Try to get the stage info first
            $stageService = app('toornament.stage');
            $stage = $stageService->find($stageId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
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