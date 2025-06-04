This document provides examples for using all the services in the ServNX Toornament API Laravel package.

## Authentication
Before using the API, ensure you have correctly set up your configuration in config/toornament.php or your .env file:
```dotenv
TOORNAMENT_API_KEY=your-api-key
TOORNAMENT_CLIENT_ID=your-client-id
TOORNAMENT_CLIENT_SECRET=your-client-secret
TOORNAMENT_REDIRECT_URI=your-redirect-uri
```

## Tournament API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all tournaments
$tournaments = Toornament::tournament()->all();

// Find a specific tournament
$tournament = Toornament::tournament()->find('378426939508809728');

// Create a new tournament
$newTournament = Toornament::tournament()->create([
    'discipline' => 'counterstrike_go',
    'name' => 'My Laravel Tournament',
    'participant_type' => 'team',
    'size' => 16,
    'timezone' => 'Europe/London',
    'platforms' => ['pc']
]);

// Update a tournament
$updatedTournament = Toornament::tournament()->update('378426939508809728', [
    'name' => 'Updated Tournament Name',
    'public' => true,
    'size' => 32
]);

// Delete a tournament
$deleted = Toornament::tournament()->delete('378426939508809728');
```

## Stage API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all stages
$stages = Toornament::stage()->all();

// Get all stages with filters
$filteredStages = Toornament::stage()->all(['tournament_ids' => '378426939508809728']);

// Find a specific stage
$stage = Toornament::stage()->find('618983668512789184');

// Get stages for a tournament
$tournamentStages = Toornament::stage()->byTournament('378426939508809728');

// Create a new stage
$newStage = Toornament::stage()->create([
    'tournament_id' => '378426939508809728',
    'number' => 1,
    'name' => 'Group Stage',
    'type' => 'pools',
    'settings' => [
        'size' => 4,
        'groups_count' => 4
    ],
    'match_settings' => [
        'format' => [
            'type' => 'best_of',
            'options' => [
                'nb_match_sets' => 3
            ]
        ]
    ],
    'auto_placement_enabled' => false
]);

// Update a stage
$updatedStage = Toornament::stage()->update('618983668512789184', [
    'name' => 'Updated Stage Name',
    'settings' => [
        'size' => 8
    ],
    'match_settings' => [
        'format' => [
            'type' => 'best_of',
            'options' => [
                'nb_match_sets' => 5
            ]
        ]
    ]
]);

// Delete a stage
$deleted = Toornament::stage()->delete('618983668512789184');

// Seed participants into a stage
$seededStage = Toornament::stage()->seedParticipants(
    '618983668512789184',
    [
        '375143143408309123',
        '375143143408309124',
        '375143143408309125',
        '375143143408309126'
    ],
    'manual'
);

// Get the bracket structure for a stage
$bracketStructure = Toornament::stage()->getBracket('618983668512789184');

// Start a stage (change status from 'pending' to 'running')
$runningStage = Toornament::stage()->start('618983668512789184');

// Access stage properties
$stageId = $stage->getId();
$stageName = $stage->getName();
$stageType = $stage->getType();
$stageNumber = $stage->getNumber();
$stageStatus = $stage->getStatus();
$tournamentId = $stage->getTournamentId();
$isClosed = $stage->isClosed();

// Get stage settings
$settings = $stage->getSettings();

// Get match settings for a stage
$matchSettings = $stage->getMatchSettings();

// Check if auto placement is enabled
$autoPlacementEnabled = $stage->isAutoPlacementEnabled();
```

## Placement API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all placement slots for a stage
$placementSlots = Toornament::placement()->all('618983668512789184');

// Update placement slots for a stage (uses PATCH method)
$updatedSlots = Toornament::placement()->update(
    '618983668512789184',
    [
        [
            'number' => 1,
            'participant_id' => '375143143408309123'
        ],
        [
            'number' => 2,
            'participant_id' => '375143143408309124'
        ],
        [
            'number' => 3,
            'participant_id' => '375143143408309125'
        ],
        [
            'number' => 4,
            'participant_id' => '375143143408309126'
        ]
    ]
);

// Update a single placement slot
$updatedSlot = Toornament::placement()->updateSlot(
    '618983668512789184',
    1,
    '375143143408309123'
);

// Remove a participant from a placement slot
$clearedSlot = Toornament::placement()->updateSlot(
    '618983668512789184',
    1,
    null
);

// Reset all placement slots for a stage
// Note: This will set all participant_ids to null, as there's no DELETE endpoint
$reset = Toornament::placement()->reset('618983668512789184');

// Verify if a stage exists before updating placements
$stageExists = Toornament::placement()->verifyStage('618983668512789184');

// Access placement properties
$slotNumber = $placementSlot->getNumber();
$participantId = $placementSlot->getParticipantId();
$isLocked = $placementSlot->isLocked(); // Check if slot is locked by structure

// Check if a slot has a participant
if ($placementSlot->getParticipantId() !== null) {
    // Slot has a participant assigned
}
```

## Participant API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all participants
$participants = Toornament::participant()->all();

// Get participants for a tournament
$tournamentParticipants = Toornament::participant()->byTournament('378426939508809728');

// Find a specific participant
$participant = Toornament::participant()->find('375143143408309123');

// Create a player participant
$playerParticipant = Toornament::participant()->create([
    'tournament_id' => '378426939508809728',
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'type' => 'player',
    'country' => 'US'
]);

// Create a team participant
$teamParticipant = Toornament::participant()->create([
    'tournament_id' => '378426939508809728',
    'name' => 'Team Laravel',
    'email' => 'team@example.com',
    'type' => 'team',
    'lineup' => [
        [
            'name' => 'Player 1',
            'email' => 'player1@example.com',
            'country' => 'US'
        ],
        [
            'name' => 'Player 2',
            'email' => 'player2@example.com',
            'country' => 'CA'
        ]
    ]
]);

// Update a participant
$updatedParticipant = Toornament::participant()->update('375143143408309123', [
    'name' => 'Updated Name',
    'checked_in' => true
]);

// Delete a participant
$deleted = Toornament::participant()->delete('375143143408309123');
```

## Match API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all matches
$matches = Toornament::match()->all();

// Find a specific match
$match = Toornament::match()->find('618954615761465416');

// Get matches for a tournament
$tournamentMatches = Toornament::match()->byTournament('378426939508809728');

// Get matches for a stage
$stageMatches = Toornament::match()->byStage('618983668512789184');

// Get matches for a group
$groupMatches = Toornament::match()->byGroup('618983668512789184');

// Get matches for a round
$roundMatches = Toornament::match()->byRound('618965146546456651');

// Get matches for a participant
$participantMatches = Toornament::match()->byParticipant('375143143408309123');

// Get matches by status
$pendingMatches = Toornament::match()->byStatus('pending');
$runningMatches = Toornament::match()->byStatus('running');
$completedMatches = Toornament::match()->byStatus('completed');

// Get scheduled matches
$scheduledMatches = Toornament::match()->scheduled();

// Get matches scheduled before/after a date
$matchesBefore = Toornament::match()->scheduledBefore('2023-12-31T00:00:00+00:00');
$matchesAfter = Toornament::match()->scheduledAfter('2023-01-01T00:00:00+00:00');

// Get matches played before/after a date
$playedBefore = Toornament::match()->playedBefore('2023-12-31T00:00:00+00:00');
$playedAfter = Toornament::match()->playedAfter('2023-01-01T00:00:00+00:00');

// Get upcoming matches
$upcomingMatches = Toornament::match()->upcoming();

// Get ongoing matches
$ongoingMatches = Toornament::match()->ongoing();

// Get completed matches
$completedMatches = Toornament::match()->completed();

// Update a match result
$updatedMatch = Toornament::match()->updateResult('618954615761465416', [
    [
        'number' => 1,
        'score' => 3,
        'result' => 'win'
    ],
    [
        'number' => 2,
        'score' => 1,
        'result' => 'loss'
    ]
]);

// Schedule a match
$scheduledMatch = Toornament::match()->schedule(
    '618954615761465416', 
    '2025-05-01T15:30:00+00:00'
);

// Add notes to a match
$annotatedMatch = Toornament::match()->addNotes(
    '618954615761465416',
    'This match was rescheduled due to technical issues.',
    'Team 1 requested the reschedule on April 10.'
);
```

## Registration API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all registrations
$registrations = Toornament::registration()->all();

// Find a specific registration
$registration = Toornament::registration()->find('12345678');

// Get registrations for a tournament
$tournamentRegistrations = Toornament::registration()->byTournament('378426939508809728');

// Get registrations by status
$pendingRegistrations = Toornament::registration()->pending();
$acceptedRegistrations = Toornament::registration()->accepted();
$refusedRegistrations = Toornament::registration()->refused();
$cancelledRegistrations = Toornament::registration()->cancelled();

// Get registrations by user
$userRegistrations = Toornament::registration()->byUser('145246939508809147');

// Get registrations by team
$teamRegistrations = Toornament::registration()->byTeam('561714159547269773');

// Get registrations by custom identifier
$customRegistrations = Toornament::registration()->byCustomUserIdentifier('acme:account:1234');

// Create a player registration
$playerRegistration = Toornament::registration()->createPlayerRegistration([
    'tournament_id' => '378426939508809728',
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'country' => 'US',
    'birth_date' => '1990-01-01',
    'custom_fields' => [
        'discord_id' => 'johndoe#1234'
    ]
]);

// Create a team registration
$teamRegistration = Toornament::registration()->createTeamRegistration([
    'tournament_id' => '378426939508809728',
    'name' => 'Team Laravel',
    'email' => 'team@example.com',
    'lineup' => [
        [
            'name' => 'Player 1',
            'email' => 'player1@example.com',
            'country' => 'US'
        ],
        [
            'name' => 'Player 2',
            'email' => 'player2@example.com',
            'country' => 'CA'
        ]
    ],
    'custom_fields' => [
        'team_logo_url' => 'https://example.com/logo.png'
    ]
]);

// Update a registration
$updatedRegistration = Toornament::registration()->update('12345678', [
    'status' => 'accepted'
]);

// Accept a registration
$acceptedRegistration = Toornament::registration()->accept('12345678');

// Refuse a registration
$refusedRegistration = Toornament::registration()->refuse('12345678');

// Cancel a registration
$cancelledRegistration = Toornament::registration()->cancel('12345678');

// Delete a registration
$deleted = Toornament::registration()->delete('12345678');
```

## Discipline API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all disciplines
$disciplines = Toornament::discipline()->all();

// Find a specific discipline by ID
$discipline = Toornament::discipline()->find('counterstrike_go');

// Find a discipline by shortname
$discipline = Toornament::discipline()->findByShortname('CS:GO');

// Find a discipline by name
$discipline = Toornament::discipline()->findByName('Counter-Strike: GO');

// Find disciplines available on a specific platform
$pcDisciplines = Toornament::discipline()->findByPlatform('pc');

// Access discipline properties
$name = $discipline->getName();
$shortname = $discipline->getShortname();
$fullname = $discipline->getFullname();
$copyrights = $discipline->getCopyrights();

// Get platform availability and team size info
$platforms = $discipline->getPlatformsAvailable();
$minTeamSize = $discipline->getMinTeamSize();
$maxTeamSize = $discipline->getMaxTeamSize();

// Check for specific features
if ($discipline->hasFeature('map')) {
    $mapFeature = $discipline->getFeature('map');
    // Do something with the map feature
}
```

## Custom Field API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all player custom fields
$playerFields = Toornament::custom_field()->playerFields();

// Get all team custom fields for a tournament
$teamFields = Toornament::custom_field()->byTournament('378426939508809728', 'team');

// Find a specific custom field
$customField = Toornament::custom_field()->find('128114939547269789');

// Create a new player custom field
$discordField = Toornament::custom_field()->createPlayerField(
    '378426939508809728',
    'discord_id',
    'Discord ID',
    'text',
    [
        'required' => true,
        'public' => false,
        'position' => 1
    ]
);

// Create a new team custom field
$logoField = Toornament::custom_field()->createTeamField(
    '378426939508809728',
    'team_logo',
    'Team Logo URL',
    'url',
    [
        'required' => false,
        'public' => true,
        'position' => 2
    ]
);

// Create a new team player custom field
$roleField = Toornament::custom_field()->createTeamPlayerField(
    '378426939508809728',
    'player_role',
    'Player Role',
    'text',
    [
        'required' => false,
        'public' => true,
        'position' => 1
    ]
);

// Update a custom field
$updatedField = Toornament::custom_field()->update('128114939547269789', [
    'label' => 'Updated Label',
    'required' => true
]);

// Set a field as required
$requiredField = Toornament::custom_field()->setRequired('128114939547269789', true);

// Set a field as public
$publicField = Toornament::custom_field()->setVisibility('128114939547269789', true);

// Set a field position
$repositionedField = Toornament::custom_field()->setPosition('128114939547269789', 3);

// Set a field default value
$defaultValueField = Toornament::custom_field()->setDefaultValue('128114939547269789', 'Default Value');

// Delete a custom field
$deleted = Toornament::custom_field()->delete('128114939547269789');
```

## Bracket API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all bracket nodes for a tournament
$bracketNodes = Toornament::bracket()->byTournament('378426939508809728');

// Get bracket nodes for a specific stage
$stageNodes = Toornament::bracket()->byStage('618983668512789184');

// Get nodes at a specific depth
$depthNodes = Toornament::bracket()->byDepth(2);

// Get nodes in a depth range
$depthRangeNodes = Toornament::bracket()->byDepthRange(1, 3);

// Get nodes in the winners bracket
$winnersNodes = Toornament::bracket()->inWinnersBracket([
    'tournament_ids' => '378426939508809728',
    'stage_ids' => '618983668512789184'
]);

// Get nodes in the losers bracket
$losersNodes = Toornament::bracket()->inLosersBracket([
    'tournament_ids' => '378426939508809728',
    'stage_ids' => '618983668512789184'
]);

// Get nodes in the grand final
$grandFinalNodes = Toornament::bracket()->inGrandFinal([
    'tournament_ids' => '378426939508809728',
    'stage_ids' => '618983668512789184'
]);

// Get the final node of a bracket
$finalNode = Toornament::bracket()->getFinal('378426939508809728', '618983668512789184');

// Get source nodes for a node
$sourceNodes = Toornament::bracket()->getSourceNodes($node);

// Build a complete bracket structure
$bracketStructure = Toornament::bracket()->buildBracketStructure(
    '378426939508809728', 
    '618983668512789184'
);

// Access node properties
$nodeId = $node->getId();
$depth = $node->getDepth();
$branch = $node->getBranch();
$opponents = $node->getOpponents();

// Get a specific opponent
$opponent = $node->getOpponent(1);

// Get the winner and loser of a node
$winner = $node->getWinner();
$loser = $node->getLoser();

// Check node properties
$isInWinnersBracket = $node->isInWinnersBracket();
$isInLosersBracket = $node->isInLosersBracket();
$isInGrandFinal = $node->isInGrandFinal();
$isCompleted = $node->isCompleted();
$isRunning = $node->isRunning();
$isPending = $node->isPending();
```

## Group API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all groups
$groups = Toornament::group()->all();

// Find a specific group
$group = Toornament::group()->find('618983668512789184');

// Get groups for a tournament
$tournamentGroups = Toornament::group()->byTournament('378426939508809728');

// Get groups for a specific stage
$stageGroups = Toornament::group()->byStage('618945443132178479');

// Get groups by stage number
$stageNumberGroups = Toornament::group()->byStageNumber(1);

// Get groups for a specific tournament and stage
$filteredGroups = Toornament::group()->byTournamentAndStage(
    '378426939508809728',
    '618945443132178479'
);

// Get groups by number
$groupsNumber2 = Toornament::group()->byNumber(2);

// Get open groups
$openGroups = Toornament::group()->open();

// Get closed groups
$closedGroups = Toornament::group()->closed();

// Get group settings
$settings = Toornament::group()->getSettings($group);

// Get group match settings
$matchSettings = Toornament::group()->getMatchSettings($group);

// Get match format
$matchFormat = Toornament::group()->getMatchFormat($group);

// Access group properties
$groupId = $group->getId();
$name = $group->getName();
$number = $group->getNumber();
$isClosed = $group->isClosed();

// Get specific settings
$pairingValues = $group->getPairingValues();
$specificSetting = $group->getSetting('some_key');
$specificMatchSetting = $group->getMatchSetting('some_key');
```

## Round API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all rounds
$rounds = Toornament::round()->all();

// Find a specific round
$round = Toornament::round()->find('618965146546456651');

// Get rounds for a tournament
$tournamentRounds = Toornament::round()->byTournament('378426939508809728');

// Get rounds for a specific stage
$stageRounds = Toornament::round()->byStage('618945443132178479');

// Get rounds by stage number
$stageNumberRounds = Toornament::round()->byStageNumber(1);

// Get rounds for a specific group
$groupRounds = Toornament::round()->byGroup('618983668512789184');

// Get rounds by group number
$groupNumberRounds = Toornament::round()->byGroupNumber(1);

// Get rounds for a specific tournament, stage, and group
$filteredRounds = Toornament::round()->byTournamentStageAndGroup(
    '378426939508809728',
    '618945443132178479',
    '618983668512789184'
);

// Get rounds by number
$roundsNumber2 = Toornament::round()->byNumber(2);

// Get open rounds
$openRounds = Toornament::round()->open();

// Get closed rounds
$closedRounds = Toornament::round()->closed();

// Get round settings
$settings = Toornament::round()->getSettings($round);

// Get round match settings
$matchSettings = Toornament::round()->getMatchSettings($round);

// Get match format
$matchFormat = Toornament::round()->getMatchFormat($round);

// Access round properties
$roundId = $round->getId();
$name = $round->getName();
$number = $round->getNumber();
$isClosed = $round->isClosed();

// Get specific settings
$pairingValues = $round->getPairingValues();
$specificSetting = $round->getSetting('some_key');
$specificMatchSetting = $round->getMatchSetting('some_key');
```

## Sponsor API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all sponsors
$sponsors = Toornament::sponsor()->all();

// Find a specific sponsor
$sponsor = Toornament::sponsor()->find('495923570669058051');

// Get sponsors for a tournament
$tournamentSponsors = Toornament::sponsor()->byTournament('378426939508809728');

// Create a new sponsor for a tournament
$newSponsor = Toornament::sponsor()->createForTournament(
    '378426939508809728',
    'Acme Corporation',
    '529400138800557511',
    'https://www.acme.com',
    1
);

// Update sponsor name
$renamedSponsor = Toornament::sponsor()->updateName('495923570669058051', 'New Sponsor Name');

// Update sponsor website
$updatedSponsor = Toornament::sponsor()->updateWebsite('495923570669058051', 'https://www.newsponsor.com');

// Update sponsor position
$repositionedSponsor = Toornament::sponsor()->updatePosition('495923570669058051', 2);

// Update sponsor logo
$reloggedSponsor = Toornament::sponsor()->updateLogo('495923570669058051', '529400138800557512');

// Reorder sponsors
Toornament::sponsor()->reorder([
    '495923570669058051',
    '495923570669058052',
    '495923570669058053'
]);

// Delete a sponsor
$deleted = Toornament::sponsor()->delete('495923570669058051');

// Access sponsor properties
$sponsorId = $sponsor->getId();
$name = $sponsor->getName();
$website = $sponsor->getWebsite();
$position = $sponsor->getPosition();
$logoId = $sponsor->getLogoId();

// Check sponsor properties
$hasWebsite = $sponsor->hasWebsite();
$hasLogo = $sponsor->hasLogo();
```

## Standing API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all standing items
$standingItems = Toornament::standing()->all();

// Find a specific standing item
$standingItem = Toornament::standing()->find('378426939508809728');

// Get standing items for a tournament
$tournamentStandings = Toornament::standing()->byTournament('378426939508809728');

// Get standing items for a participant
$participantStandings = Toornament::standing()->byParticipant('375143143408309123');

// Get standing items by user
$userStandings = Toornament::standing()->byUser('145246939508809147');

// Get standing items by team
$teamStandings = Toornament::standing()->byTeam('561714159547269773');

// Get standing items by custom user identifier
$customStandings = Toornament::standing()->byCustomUserIdentifier('acme:account:1234');

// Get standing items by rank range
$topStandings = Toornament::standing()->byRankRange(1, 3);

// Create a new standing item
$newStanding = Toornament::standing()->createForParticipant(
    '378426939508809728',
    '375143143408309123',
    1
);

// Update a standing item's rank
$updatedStanding = Toornament::standing()->updateRank('378426939508809728', 2);

// Get the top 3 ranked participants in a tournament
$topThree = Toornament::standing()->getTopRanked('378426939508809728', 3);

// Delete a standing item
$deleted = Toornament::standing()->delete('378426939508809728');

// Access standing item properties
$standingId = $standingItem->getId();
$rank = $standingItem->getRank();
$position = $standingItem->getPosition();
$participantName = $standingItem->getParticipantName();
```

## Match Report API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all match reports
$matchReports = Toornament::match_report()->all();

// Find a specific match report
$matchReport = Toornament::match_report()->find('168954615761461654');

// Get match reports for a tournament
$tournamentReports = Toornament::match_report()->byTournament('378426939508809728');

// Get match reports for a match
$matchReports = Toornament::match_report()->byMatch('618954615761465416');

// Get reports by participant
$participantReports = Toornament::match_report()->byParticipant('375143143408309123');

// Get reports by user
$userReports = Toornament::match_report()->byUser('513743143408302391');

// Get reports by team
$teamReports = Toornament::match_report()->byTeam('561714159547269773');

// Get reports by custom user identifier
$customReports = Toornament::match_report()->byCustomUserIdentifier('acme:account:1234');

// Get reports by type
$reportsOnly = Toornament::match_report()->byType('report');
$disputesOnly = Toornament::match_report()->byType('dispute');

// Get closed reports
$closedReports = Toornament::match_report()->closed();

// Get open reports
$openReports = Toornament::match_report()->open();

// Get all standard reports
$standardReports = Toornament::match_report()->reports();

// Get all disputes
$disputes = Toornament::match_report()->disputes();

// Create a report for a match
$newReport = Toornament::match_report()->createReport(
    '618954615761465416',
    '375143143408309123',
    [
        [
            'number' => 1,
            'score' => 3,
            'result' => 'win',
            'forfeit' => false
        ],
        [
            'number' => 2,
            'score' => 1,
            'result' => 'loss',
            'forfeit' => false
        ]
    ],
    'We won 3-1.'
);

// Create a dispute for a match
$newDispute = Toornament::match_report()->createDispute(
    '618954615761465416',
    '375143143408309123',
    [
        [
            'number' => 1,
            'score' => 3,
            'result' => 'win',
            'forfeit' => false
        ],
        [
            'number' => 2,
            'score' => 2,
            'result' => 'loss',
            'forfeit' => false
        ]
    ],
    'Our opponent is reporting 3-1 but the correct score is 3-2.'
);

// Close a match report
$closedReport = Toornament::match_report()->close('168954615761461654');

// Add a note to a match report
$updatedReport = Toornament::match_report()->addNote('168954615761461654', 'Score confirmed by admin.');

// Access match report properties
$reportId = $matchReport->getId();
$type = $matchReport->getType();
$isClosed = $matchReport->isClosed();
$note = $matchReport->getNote();
$opponents = $matchReport->getOpponents();

// Check match report properties
$isReport = $matchReport->isReport();
$isDispute = $matchReport->isDispute();
$hasNote = $matchReport->hasNote();
$hasProofs = $matchReport->hasProofs();
```

## Match Game API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all games for a match
$games = Toornament::match_game()->allForMatch('618954615761465416');

// Find a specific game
$game = Toornament::match_game()->find('618954615761465416', 1);

// Update a game result
$updatedGame = Toornament::match_game()->updateResult(
    '618954615761465416',
    1,
    [
        [
            'number' => 1,
            'score' => 10,
            'result' => 'win',
            'forfeit' => false
        ],
        [
            'number' => 2,
            'score' => 5,
            'result' => 'loss',
            'forfeit' => false
        ]
    ]
);

// Update game status
$completedGame = Toornament::match_game()->setCompleted('618954615761465416', 1);
$runningGame = Toornament::match_game()->setRunning('618954615761465416', 2);
$pendingGame = Toornament::match_game()->setPending('618954615761465416', 3);

// Update game properties
$updatedGame = Toornament::match_game()->updateProperties(
    '618954615761465416',
    1,
    [
        'map' => 'de_dust2',
        'duration' => 45
    ]
);

// Update opponent properties
$updatedGame = Toornament::match_game()->updateOpponentProperties(
    '618954615761465416',
    1,
    1,
    [
        'side' => 'CT',
        'kills' => 25,
        'deaths' => 12
    ]
);

// Get completed games
$completedGames = Toornament::match_game()->getCompletedGames('618954615761465416');

// Get pending games
$pendingGames = Toornament::match_game()->getPendingGames('618954615761465416');

// Get running games
$runningGames = Toornament::match_game()->getRunningGames('618954615761465416');

// Access game properties
$gameNumber = $game->getNumber();
$status = $game->getStatus();
$opponents = $game->getOpponents();
$properties = $game->getProperties();

// Get an opponent
$opponent = $game->getOpponent(1);

// Get a property
$map = $game->getProperty('map');

// Get opponent properties
$opponentProperties = $game->getOpponentProperties(1);
$side = $game->getOpponentProperty(1, 'side');

// Get winner and loser
$winner = $game->getWinner();
$loser = $game->getLoser();

// Check game status
$isCompleted = $game->isCompleted();
$isRunning = $game->isRunning();
$isPending = $game->isPending();
```

## Ranking API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all ranking items
$rankings = Toornament::ranking()->all();

// Get ranking items for a tournament
$tournamentRankings = Toornament::ranking()->byTournament('378426939508809728');

// Get ranking items for a specific stage
$stageRankings = Toornament::ranking()->byStage('618983668512789184');

// Get ranking items by stage number
$stageNumberRankings = Toornament::ranking()->byStageNumber(1);

// Get ranking items for a specific group
$groupRankings = Toornament::ranking()->byGroup('618983668512789184');

// Get ranking items by group number
$groupNumberRankings = Toornament::ranking()->byGroupNumber(1);

// Get ranking items for a specific participant
$participantRankings = Toornament::ranking()->byParticipant('375143143408309123');

// Get ranking items by user
$userRankings = Toornament::ranking()->byUser('145246939508809147');

// Get ranking items by team
$teamRankings = Toornament::ranking()->byTeam('561714159547269773');

// Get ranking items by custom user identifier
$customRankings = Toornament::ranking()->byCustomUserIdentifier('acme:account:1234');

// Get ranking items by rank range
$topRankings = Toornament::ranking()->byRankRange(1, 3);

// Get ranking items for a tournament stage
$stageRankings = Toornament::ranking()->byTournamentAndStage(
    '378426939508809728',
    '618983668512789184'
);

// Get ranking items for a tournament group
$groupRankings = Toornament::ranking()->byTournamentAndGroup(
    '378426939508809728',
    '618983668512789184'
);

// Get top 3 ranked participants in a tournament
$topThree = Toornament::ranking()->getTopRankedInTournament('378426939508809728', 3);

// Get top 5 ranked participants in a stage
$topFiveInStage = Toornament::ranking()->getTopRankedInStage(
    '378426939508809728',
    '618983668512789184',
    5
);

// Get top 3 ranked participants in a group
$topThreeInGroup = Toornament::ranking()->getTopRankedInGroup(
    '378426939508809728',
    '618983668512789184',
    3
);

// Access ranking item properties
$rankingId = $rankingItem->getId();
$position = $rankingItem->getPosition();
$rank = $rankingItem->getRank();
$points = $rankingItem->getPoints();
$participantName = $rankingItem->getParticipantName();

// Access ranking statistics
$wins = $rankingItem->getWins();
$draws = $rankingItem->getDraws();
$losses = $rankingItem->getLosses();
$played = $rankingItem->getPlayed();
$forfeits = $rankingItem->getForfeits();

// Access score properties (if available)
$scoreFor = $rankingItem->getScoreFor();
$scoreAgainst = $rankingItem->getScoreAgainst();
$scoreDifference = $rankingItem->getScoreDifference();

// Access Swiss format properties (if available)
$matchHistory = $rankingItem->getMatchHistory();
$isDropped = $rankingItem->isDropped();
```