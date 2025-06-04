<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use ServNX\Toornament\Services\PlacementService;
use ServNX\Toornament\Toornament;
use ServNX\Toornament\Http\ToornamentClient;
use ServNX\Toornament\Models\Placement;
use Mockery;

class PlacementServiceTest extends TestCase
{
    protected $toornament;
    protected $client;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->client = Mockery::mock(ToornamentClient::class);
        $this->toornament = Mockery::mock(Toornament::class);
        $this->toornament->shouldReceive('getClient')->andReturn($this->client);
        
        $this->service = new PlacementService($this->toornament);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetAllPlacements()
    {
        $stageId = 'stage123';
        $placementData = [
            [
                'number' => 1,
                'participant_id' => 'participant123',
                'locked' => false
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456',
                'locked' => false
            ]
        ];

        $this->client->shouldReceive('request')
            ->once()
            ->with('GET', "stages/{$stageId}/slots", [], 'organizer:placement')
            ->andReturn($placementData);

        $placements = $this->service->all($stageId);

        $this->assertCount(2, $placements);
        $this->assertInstanceOf(Placement::class, $placements[0]);
        $this->assertEquals(1, $placements[0]->getNumber());
        $this->assertEquals('participant123', $placements[0]->getParticipantId());
        $this->assertFalse($placements[0]->isLocked());
    }

    public function testUpdatePlacements()
    {
        $stageId = 'stage123';
        $slots = [
            [
                'number' => 1,
                'participant_id' => 'participant123'
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456'
            ]
        ];
        
        $responseData = [
            [
                'number' => 1,
                'participant_id' => 'participant123',
                'locked' => false
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456',
                'locked' => false
            ]
        ];

        $this->client->shouldReceive('request')
            ->once()
            ->with('PATCH', "stages/{$stageId}/slots", ['json' => $slots], 'organizer:placement')
            ->andReturn($responseData);

        $placements = $this->service->update($stageId, $slots);

        $this->assertCount(2, $placements);
        $this->assertInstanceOf(Placement::class, $placements[0]);
        $this->assertEquals(1, $placements[0]->getNumber());
        $this->assertEquals('participant123', $placements[0]->getParticipantId());
    }

    public function testResetPlacements()
    {
        $stageId = 'stage123';
        
        // Current slots that need to be reset
        $currentSlots = [
            [
                'number' => 1,
                'participant_id' => 'participant123',
                'locked' => false
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456',
                'locked' => false
            ]
        ];
        
        // Expected reset request (all participant_ids set to null)
        $resetSlots = [
            [
                'number' => 1,
                'participant_id' => null
            ],
            [
                'number' => 2,
                'participant_id' => null
            ]
        ];
        
        // Response after reset
        $responseData = [
            [
                'number' => 1,
                'participant_id' => null,
                'locked' => false
            ],
            [
                'number' => 2,
                'participant_id' => null,
                'locked' => false
            ]
        ];

        $this->client->shouldReceive('request')
            ->once()
            ->with('GET', "stages/{$stageId}/slots", [], 'organizer:placement')
            ->andReturn($currentSlots);
            
        $this->client->shouldReceive('request')
            ->once()
            ->with('PATCH', "stages/{$stageId}/slots", ['json' => $resetSlots], 'organizer:placement')
            ->andReturn($responseData);

        $result = $this->service->reset($stageId);

        $this->assertTrue($result);
    }

    public function testUpdateSingleSlot()
    {
        $stageId = 'stage123';
        $slotNumber = 1;
        $participantId = 'participant789';
        
        // Current slots
        $currentSlots = [
            [
                'number' => 1,
                'participant_id' => 'participant123',
                'locked' => false
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456',
                'locked' => false
            ]
        ];

        // Expected update request
        $expectedUpdate = [
            [
                'number' => 1,
                'participant_id' => 'participant789'
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456'
            ]
        ];

        // Response after update
        $responseData = [
            [
                'number' => 1,
                'participant_id' => 'participant789',
                'locked' => false
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456',
                'locked' => false
            ]
        ];

        $this->client->shouldReceive('request')
            ->once()
            ->with('GET', "stages/{$stageId}/slots", [], 'organizer:placement')
            ->andReturn($currentSlots);

        $this->client->shouldReceive('request')
            ->once()
            ->with('PATCH', "stages/{$stageId}/slots", ['json' => $expectedUpdate], 'organizer:placement')
            ->andReturn($responseData);

        $placement = $this->service->updateSlot($stageId, $slotNumber, $participantId);

        $this->assertInstanceOf(Placement::class, $placement);
        $this->assertEquals(1, $placement->getNumber());
        $this->assertEquals('participant789', $placement->getParticipantId());
    }

    public function testUpdateSingleSlotWithNewSlot()
    {
        $stageId = 'stage123';
        $slotNumber = 3;
        $participantId = 'participant789';
        
        // Current slots (slot 3 doesn't exist)
        $currentSlots = [
            [
                'number' => 1,
                'participant_id' => 'participant123',
                'locked' => false
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456',
                'locked' => false
            ]
        ];

        // Expected update request (includes new slot)
        $expectedUpdate = [
            [
                'number' => 1,
                'participant_id' => 'participant123'
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456'
            ],
            [
                'number' => 3,
                'participant_id' => 'participant789'
            ]
        ];

        // Response after update
        $responseData = [
            [
                'number' => 1,
                'participant_id' => 'participant123',
                'locked' => false
            ],
            [
                'number' => 2,
                'participant_id' => 'participant456',
                'locked' => false
            ],
            [
                'number' => 3,
                'participant_id' => 'participant789',
                'locked' => false
            ]
        ];

        $this->client->shouldReceive('request')
            ->once()
            ->with('GET', "stages/{$stageId}/slots", [], 'organizer:placement')
            ->andReturn($currentSlots);

        $this->client->shouldReceive('request')
            ->once()
            ->with('PATCH', "stages/{$stageId}/slots", ['json' => $expectedUpdate], 'organizer:placement')
            ->andReturn($responseData);

        $placement = $this->service->updateSlot($stageId, $slotNumber, $participantId);

        $this->assertInstanceOf(Placement::class, $placement);
        $this->assertEquals(3, $placement->getNumber());
        $this->assertEquals('participant789', $placement->getParticipantId());
    }

    public function testPlacementModelGetters()
    {
        $data = [
            'number' => 1,
            'participant_id' => 'participant123',
            'locked' => true
        ];

        $placement = new Placement($data);

        $this->assertEquals(1, $placement->getNumber());
        $this->assertEquals('participant123', $placement->getParticipantId());
        $this->assertTrue($placement->isLocked());
        $this->assertEquals($data, $placement->toArray());
        $this->assertEquals($data, $placement->jsonSerialize());
    }

    public function testPlacementModelWithNullParticipant()
    {
        $data = [
            'number' => 1,
            'participant_id' => null
        ];

        $placement = new Placement($data);

        $this->assertEquals(1, $placement->getNumber());
        $this->assertNull($placement->getParticipantId());
        $this->assertNull($placement->isLocked());
    }
}