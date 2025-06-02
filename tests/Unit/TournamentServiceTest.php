<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use ServNX\Toornament\Http\ToornamentClient;
use ServNX\Toornament\Services\TournamentService;
use ServNX\Toornament\Toornament;

class TournamentServiceTest extends TestCase
{
    protected $clientMock;
    protected $toornamentMock;
    protected $service;

    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(ToornamentClient::class);
        $this->toornamentMock = $this->getMockBuilder(Toornament::class)
            ->setConstructorArgs([$this->clientMock])
            ->getMock();
        
        $this->toornamentMock->method('getClient')
            ->willReturn($this->clientMock);
            
        $this->service = new TournamentService($this->toornamentMock);
    }

    public function testFindTournament()
    {
        $tournamentData = [
            'id' => '123456789',
            'name' => 'Test Tournament',
            'discipline' => 'test_discipline',
            'status' => 'pending',
        ];

        $this->clientMock->expects($this->once())
            ->method('request')
            ->with('GET', 'tournaments/123456789', [], 'organizer:view')
            ->willReturn($tournamentData);

        $tournament = $this->service->find('123456789');

        $this->assertEquals('123456789', $tournament->getId());
        $this->assertEquals('Test Tournament', $tournament->getName());
    }
}