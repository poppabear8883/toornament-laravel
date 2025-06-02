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
$tournaments = Toornament::tournaments()->all();

// Find a specific tournament
$tournament = Toornament::tournaments()->find('378426939508809728');

// Create a new tournament
$newTournament = Toornament::tournaments()->create([
    'discipline' => 'counterstrike_go',
    'name' => 'My Laravel Tournament',
    'participant_type' => 'team',
    'size' => 16,
    'timezone' => 'Europe/London',
    'platforms' => ['pc']
]);

// Update a tournament
$updatedTournament = Toornament::tournaments()->update('378426939508809728', [
    'name' => 'Updated Tournament Name',
    'public' => true,
    'size' => 32
]);

// Delete a tournament
$deleted = Toornament::tournaments()->delete('378426939508809728');
```

## Stage API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all stages
$stages = Toornament::stages()->all();

// Get all stages with filters
$filteredStages = Toornament::stages()->all(['tournament_ids' => '378426939508809728']);

// Find a specific stage
$stage = Toornament::stages()->find('618983668512789184');

// Get stages for a tournament
$tournamentStages = Toornament::stages()->byTournament('378426939508809728');

// Create a new stage
$newStage = Toornament::stages()->create([
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
$updatedStage = Toornament::stages()->update('618983668512789184', [
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
$deleted = Toornament::stages()->delete('618983668512789184');

// Seed participants into a stage
$seededStage = Toornament::stages()->seedParticipants(
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
$bracketStructure = Toornament::stages()->getBracket('618983668512789184');

// Start a stage (change status from 'pending' to 'running')
$runningStage = Toornament::stages()->start('618983668512789184');

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
$placementSlots = Toornament::placements()->all('618983668512789184');

// Update placement slots for a stage
$updatedSlots = Toornament::placements()->update(
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
$updatedSlot = Toornament::placements()->updateSlot(
    '618983668512789184',
    1,
    '375143143408309123'
);

// Remove a participant from a placement slot
$clearedSlot = Toornament::placements()->updateSlot(
    '618983668512789184',
    1,
    null
);

// Reset all placement slots for a stage
$reset = Toornament::placements()->reset('618983668512789184');

// Access placement properties
$slotNumber = $placementSlot->getNumber();
$participantId = $placementSlot->getParticipantId();
$hasParticipant = $placementSlot->hasParticipant();
```

## Participant API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all participants
$participants = Toornament::participants()->all();

// Get participants for a tournament
$tournamentParticipants = Toornament::participants()->byTournament('378426939508809728');

// Find a specific participant
$participant = Toornament::participants()->find('375143143408309123');

// Create a player participant
$playerParticipant = Toornament::participants()->create([
    'tournament_id' => '378426939508809728',
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'type' => 'player',
    'country' => 'US'
]);

// Create a team participant
$teamParticipant = Toornament::participants()->create([
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
$updatedParticipant = Toornament::participants()->update('375143143408309123', [
    'name' => 'Updated Name',
    'checked_in' => true
]);

// Delete a participant
$deleted = Toornament::participants()->delete('375143143408309123');
```

## Match API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all matches
$matches = Toornament::matches()->all();

// Find a specific match
$match = Toornament::matches()->find('618954615761465416');

// Get matches for a tournament
$tournamentMatches = Toornament::matches()->byTournament('378426939508809728');

// Get matches for a stage
$stageMatches = Toornament::matches()->byStage('618983668512789184');

// Get matches for a group
$groupMatches = Toornament::matches()->byGroup('618983668512789184');

// Get matches for a round
$roundMatches = Toornament::matches()->byRound('618965146546456651');

// Get matches for a participant
$participantMatches = Toornament::matches()->byParticipant('375143143408309123');

// Get matches by status
$pendingMatches = Toornament::matches()->byStatus('pending');
$runningMatches = Toornament::matches()->byStatus('running');
$completedMatches = Toornament::matches()->byStatus('completed');

// Get scheduled matches
$scheduledMatches = Toornament::matches()->scheduled();

// Get matches scheduled before/after a date
$matchesBefore = Toornament::matches()->scheduledBefore('2023-12-31T00:00:00+00:00');
$matchesAfter = Toornament::matches()->scheduledAfter('2023-01-01T00:00:00+00:00');

// Get matches played before/after a date
$playedBefore = Toornament::matches()->playedBefore('2023-12-31T00:00:00+00:00');
$playedAfter = Toornament::matches()->playedAfter('2023-01-01T00:00:00+00:00');

// Get upcoming matches
$upcomingMatches = Toornament::matches()->upcoming();

// Get ongoing matches
$ongoingMatches = Toornament::matches()->ongoing();

// Get completed matches
$completedMatches = Toornament::matches()->completed();

// Update a match result
$updatedMatch = Toornament::matches()->updateResult('618954615761465416', [
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
$scheduledMatch = Toornament::matches()->schedule(
    '618954615761465416', 
    '2025-05-01T15:30:00+00:00'
);

// Add notes to a match
$annotatedMatch = Toornament::matches()->addNotes(
    '618954615761465416',
    'This match was rescheduled due to technical issues.',
    'Team 1 requested the reschedule on April 10.'
);
```

## Registration API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all registrations
$registrations = Toornament::registrations()->all();

// Find a specific registration
$registration = Toornament::registrations()->find('12345678');

// Get registrations for a tournament
$tournamentRegistrations = Toornament::registrations()->byTournament('378426939508809728');

// Get registrations by status
$pendingRegistrations = Toornament::registrations()->pending();
$acceptedRegistrations = Toornament::registrations()->accepted();
$refusedRegistrations = Toornament::registrations()->refused();
$cancelledRegistrations = Toornament::registrations()->cancelled();

// Get registrations by user
$userRegistrations = Toornament::registrations()->byUser('145246939508809147');

// Get registrations by team
$teamRegistrations = Toornament::registrations()->byTeam('561714159547269773');

// Get registrations by custom identifier
$customRegistrations = Toornament::registrations()->byCustomUserIdentifier('acme:account:1234');

// Create a player registration
$playerRegistration = Toornament::registrations()->createPlayerRegistration([
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
$teamRegistration = Toornament::registrations()->createTeamRegistration([
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
$updatedRegistration = Toornament::registrations()->update('12345678', [
    'status' => 'accepted'
]);

// Accept a registration
$acceptedRegistration = Toornament::registrations()->accept('12345678');

// Refuse a registration
$refusedRegistration = Toornament::registrations()->refuse('12345678');

// Cancel a registration
$cancelledRegistration = Toornament::registrations()->cancel('12345678');

// Delete a registration
$deleted = Toornament::registrations()->delete('12345678');
```

## Discipline API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all disciplines
$disciplines = Toornament::disciplines()->all();

// Find a specific discipline by ID
$discipline = Toornament::disciplines()->find('counterstrike_go');

// Find a discipline by shortname
$discipline = Toornament::disciplines()->findByShortname('CS:GO');

// Find a discipline by name
$discipline = Toornament::disciplines()->findByName('Counter-Strike: GO');

// Find disciplines available on a specific platform
$pcDisciplines = Toornament::disciplines()->findByPlatform('pc');

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
$playerFields = Toornament::custom_fields()->playerFields();

// Get all team custom fields for a tournament
$teamFields = Toornament::custom_fields()->byTournament('378426939508809728', 'team');

// Find a specific custom field
$customField = Toornament::custom_fields()->find('128114939547269789');

// Create a new player custom field
$discordField = Toornament::custom_fields()->createPlayerField(
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
$logoField = Toornament::custom_fields()->createTeamField(
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
$roleField = Toornament::custom_fields()->createTeamPlayerField(
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
$updatedField = Toornament::custom_fields()->update('128114939547269789', [
    'label' => 'Updated Label',
    'required' => true
]);

// Set a field as required
$requiredField = Toornament::custom_fields()->setRequired('128114939547269789', true);

// Set a field as public
$publicField = Toornament::custom_fields()->setVisibility('128114939547269789', true);

// Set a field position
$repositionedField = Toornament::custom_fields()->setPosition('128114939547269789', 3);

// Set a field default value
$defaultValueField = Toornament::custom_fields()->setDefaultValue('128114939547269789', 'Default Value');

// Delete a custom field
$deleted = Toornament::custom_fields()->delete('128114939547269789');
```

## Bracket API
```php
use ServNX\Toornament\Facades\Toornament;

// Get all bracket nodes for a tournament
$bracketNodes = Toornament::brackets()->byTournament('378426939508809728');

// Get bracket nodes for a specific stage
$stageNodes = Toornament::brackets()->byStage('618983668512789184');

// Get nodes at a specific depth
$depthNodes = Toornament::brackets()->byDepth(2);

// Get nodes in a depth range
$depthRangeNodes = Toornament::brackets()->byDepthRange(1, 3);

// Get nodes in the winners bracket
$winnersNodes = Toornament::brackets()->inWinnersBracket([
    'tournament_ids' => '378426939508809728',
    'stage_ids' => '618983668512789184'
]);

// Get nodes in the losers bracket
$losersNodes = Toornament::brackets()->inLosersBracket([
    'tournament_ids' => '378426939508809728',
    'stage_ids' => '618983668512789184'
]);

// Get nodes in the grand final
$grandFinalNodes = Toornament::brackets()->inGrandFinal([
    'tournament_ids' => '378426939508809728',
    'stage_ids' => '618983668512789184'
]);

// Get the final node of a bracket
$finalNode = Toornament::brackets()->getFinal('378426939508809728', '618983668512789184');

// Get source nodes for a node
$sourceNodes = Toornament::brackets()->getSourceNodes($node);

// Build a complete bracket structure
$bracketStructure = Toornament::brackets()->buildBracketStructure(
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
$groups = Toornament::groups()->all();

// Find a specific group
$group = Toornament::groups()->find('618983668512789184');

// Get groups for a tournament
$tournamentGroups = Toornament::groups()->byTournament('378426939508809728');

// Get groups for a specific stage
$stageGroups = Toornament::groups()->byStage('618945443132178479');

// Get groups by stage number
$stageNumberGroups = Toornament::groups()->byStageNumber(1);

// Get groups for a specific tournament and stage
$filteredGroups = Toornament::groups()->byTournamentAndStage(
    '378426939508809728',
    '618945443132178479'
);

// Get groups by number
$groupsNumber2 = Toornament::groups()->byNumber(2);

// Get open groups
$openGroups = Toornament::groups()->open();

// Get closed groups
$closedGroups = Toornament::groups()->closed();

// Get group settings
$settings = Toornament::groups()->getSettings($group);

// Get group match settings
$matchSettings = Toornament::groups()->getMatchSettings($group);

// Get match format
$matchFormat = Toornament::groups()->getMatchFormat($group);

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
$rounds = Toornament::rounds()->all();

// Find a specific round
$round = Toornament::rounds()->find('618965146546456651');

// Get rounds for a tournament
$tournamentRounds = Toornament::rounds()->byTournament('378426939508809728');

// Get rounds for a specific stage
$stageRounds = Toornament::rounds()->byStage('618945443132178479');

// Get rounds by stage number
$stageNumberRounds = Toornament::rounds()->byStageNumber(1);

// Get rounds for a specific group
$groupRounds = Toornament::rounds()->byGroup('618983668512789184');

// Get rounds by group number
$groupNumberRounds = Toornament::rounds()->byGroupNumber(1);

// Get rounds for a specific tournament, stage, and group
$filteredRounds = Toornament::rounds()->byTournamentStageAndGroup(
    '378426939508809728',
    '618945443132178479',
    '618983668512789184'
);

// Get rounds by number
$roundsNumber2 = Toornament::rounds()->byNumber(2);

// Get open rounds
$openRounds = Toornament::rounds()->open();

// Get closed rounds
$closedRounds = Toornament::rounds()->closed();

// Get round settings
$settings = Toornament::rounds()->getSettings($round);

// Get round match settings
$matchSettings = Toornament::rounds()->getMatchSettings($round);

// Get match format
$matchFormat = Toornament::rounds()->getMatchFormat($round);

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
$sponsors = Toornament::sponsors()->all();

// Find a specific sponsor
$sponsor = Toornament::sponsors()->find('495923570669058051');

// Get sponsors for a tournament
$tournamentSponsors = Toornament::sponsors()->byTournament('378426939508809728');

// Create a new sponsor for a tournament
$newSponsor = Toornament::sponsors()->createForTournament(
    '378426939508809728',
    'Acme Corporation',
    '529400138800557511',
    'https://www.acme.com',
    1
);

// Update sponsor name
$renamedSponsor = Toornament::sponsors()->updateName('495923570669058051', 'New Sponsor Name');

// Update sponsor website
$updatedSponsor = Toornament::sponsors()->updateWebsite('495923570669058051', 'https://www.newsponsor.com');

// Update sponsor position
$repositionedSponsor = Toornament::sponsors()->updatePosition('495923570669058051', 2);

// Update sponsor logo
$reloggedSponsor = Toornament::sponsors()->updateLogo('495923570669058051', '529400138800557512');

// Reorder sponsors
Toornament::sponsors()->reorder([
    '495923570669058051',
    '495923570669058052',
    '495923570669058053'
]);

// Delete a sponsor
$deleted = Toornament::sponsors()->delete('495923570669058051');

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
$standingItems = Toornament::standings()->all();

// Find a specific standing item
$standingItem = Toornament::standings()->find('378426939508809728');

// Get standing items for a tournament
$tournamentStandings = Toornament::standings()->byTournament('378426939508809728');

// Get standing items for a participant
$participantStandings = Toornament::standings()->byParticipant('375143143408309123');

// Get standing items by user
$userStandings = Toornament::standings()->byUser('145246939508809147');

// Get standing items by team
$teamStandings = Toornament::standings()->byTeam('561714159547269773');

// Get standing items by custom user identifier
$customStandings = Toornament::standings()->byCustomUserIdentifier('acme:account:1234');

// Get standing items by rank range
$topStandings = Toornament::standings()->byRankRange(1, 3);

// Create a new standing item
$newStanding = Toornament::standings()->createForParticipant(
    '378426939508809728',
    '375143143408309123',
    1
);

// Update a standing item's rank
$updatedStanding = Toornament::standings()->updateRank('378426939508809728', 2);

// Get the top 3 ranked participants in a tournament
$topThree = Toornament::standings()->getTopRanked('378426939508809728', 3);

// Delete a standing item
$deleted = Toornament::standings()->delete('378426939508809728');

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
$matchReports = Toornament::match_reports()->all();

// Find a specific match report
$matchReport = Toornament::match_reports()->find('168954615761461654');

// Get match reports for a tournament
$tournamentReports = Toornament::match_reports()->byTournament('378426939508809728');

// Get match reports for a match
$matchReports = Toornament::match_reports()->byMatch('618954615761465416');

// Get reports by participant
$participantReports = Toornament::match_reports()->byParticipant('375143143408309123');

// Get reports by user
$userReports = Toornament::match_reports()->byUser('513743143408302391');

// Get reports by team
$teamReports = Toornament::match_reports()->byTeam('561714159547269773');

// Get reports by custom user identifier
$customReports = Toornament::match_reports()->byCustomUserIdentifier('acme:account:1234');

// Get reports by type
$reportsOnly = Toornament::match_reports()->byType('report');
$disputesOnly = Toornament::match_reports()->byType('dispute');

// Get closed reports
$closedReports = Toornament::match_reports()->closed();

// Get open reports
$openReports = Toornament::match_reports()->open();

// Get all standard reports
$standardReports = Toornament::match_reports()->reports();

// Get all disputes
$disputes = Toornament::match_reports()->disputes();

// Create a report for a match
$newReport = Toornament::match_reports()->createReport(
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
$newDispute = Toornament::match_reports()->createDispute(
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
$closedReport = Toornament::match_reports()->close('168954615761461654');

// Add a note to a match report
$updatedReport = Toornament::match_reports()->addNote('168954615761461654', 'Score confirmed by admin.');

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
$games = Toornament::match_games()->allForMatch('618954615761465416');

// Find a specific game
$game = Toornament::match_games()->find('618954615761465416', 1);

// Update a game result
$updatedGame = Toornament::match_games()->updateResult(
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
$completedGame = Toornament::match_games()->setCompleted('618954615761465416', 1);
$runningGame = Toornament::match_games()->setRunning('618954615761465416', 2);
$pendingGame = Toornament::match_games()->setPending('618954615761465416', 3);

// Update game properties
$updatedGame = Toornament::match_games()->updateProperties(
    '618954615761465416',
    1,
    [
        'map' => 'de_dust2',
        'duration' => 45
    ]
);

// Update opponent properties
$updatedGame = Toornament::match_games()->updateOpponentProperties(
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
$completedGames = Toornament::match_games()->getCompletedGames('618954615761465416');

// Get pending games
$pendingGames = Toornament::match_games()->getPendingGames('618954615761465416');

// Get running games
$runningGames = Toornament::match_games()->getRunningGames('618954615761465416');

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
$rankings = Toornament::rankings()->all();

// Get ranking items for a tournament
$tournamentRankings = Toornament::rankings()->byTournament('378426939508809728');

// Get ranking items for a specific stage
$stageRankings = Toornament::rankings()->byStage('618983668512789184');

// Get ranking items by stage number
$stageNumberRankings = Toornament::rankings()->byStageNumber(1);

// Get ranking items for a specific group
$groupRankings = Toornament::rankings()->byGroup('618983668512789184');

// Get ranking items by group number
$groupNumberRankings = Toornament::rankings()->byGroupNumber(1);

// Get ranking items for a specific participant
$participantRankings = Toornament::rankings()->byParticipant('375143143408309123');

// Get ranking items by user
$userRankings = Toornament::rankings()->byUser('145246939508809147');

// Get ranking items by team
$teamRankings = Toornament::rankings()->byTeam('561714159547269773');

// Get ranking items by custom user identifier
$customRankings = Toornament::rankings()->byCustomUserIdentifier('acme:account:1234');

// Get ranking items by rank range
$topRankings = Toornament::rankings()->byRankRange(1, 3);

// Get ranking items for a tournament stage
$stageRankings = Toornament::rankings()->byTournamentAndStage(
    '378426939508809728',
    '618983668512789184'
);

// Get ranking items for a tournament group
$groupRankings = Toornament::rankings()->byTournamentAndGroup(
    '378426939508809728',
    '618983668512789184'
);

// Get top 3 ranked participants in a tournament
$topThree = Toornament::rankings()->getTopRankedInTournament('378426939508809728', 3);

// Get top 5 ranked participants in a stage
$topFiveInStage = Toornament::rankings()->getTopRankedInStage(
    '378426939508809728',
    '618983668512789184',
    5
);

// Get top 3 ranked participants in a group
$topThreeInGroup = Toornament::rankings()->getTopRankedInGroup(
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