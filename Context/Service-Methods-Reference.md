# Laratoor Service Methods Reference

This document provides a comprehensive list of all available methods for each service in the Laratoor package.

## Table of Contents

- [BracketService](#bracketservice)
- [CustomFieldService](#customfieldservice)
- [DisciplineService](#disciplineservice)
- [GroupService](#groupservice)
- [MatchGameService](#matchgameservice)
- [MatchReportService](#matchreportservice)
- [MatchService](#matchservice)
- [ParticipantService](#participantservice)
- [RankingService](#rankingservice)
- [RegistrationService](#registrationservice)
- [RoundService](#roundservice)
- [SponsorService](#sponsorservice)
- [StageService](#stageservice)
- [StandingService](#standingservice)
- [TournamentService](#tournamentservice)
- [WebhookService](#webhookservice)

---

## BracketService

Manages tournament bracket structures and nodes.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all bracket nodes |
| `byTournament(string $tournamentId, array $filters = [])` | Get bracket nodes for a specific tournament |
| `byStage(string $stageId, array $filters = [])` | Get bracket nodes for a specific stage |
| `byGroup(string $groupId, array $filters = [])` | Get bracket nodes for a specific group |
| `byRound(string $roundId, array $filters = [])` | Get bracket nodes for a specific round |
| `byDepth(int $depth, array $filters = [])` | Get bracket nodes at a specific depth level |
| `byDepthRange(int $minDepth, int $maxDepth, array $filters = [])` | Get bracket nodes within a depth range |
| `byTournamentAndStage(string $tournamentId, string $stageId, array $filters = [])` | Get bracket nodes by tournament and stage combination |
| `inWinnersBracket(array $filters = [])` | Get nodes in the winners' bracket |
| `inLosersBracket(array $filters = [])` | Get nodes in the losers' bracket |
| `inGrandFinal(array $filters = [])` | Get nodes in the grand final |
| `getFinal(string $tournamentId, string $stageId)` | Get the final bracket node |
| `getSourceNodes(BracketNode $node)` | Get source nodes feeding into a specific node |
| `buildBracketStructure(string $tournamentId, string $stageId)` | Build complete bracket structure hierarchy |

## CustomFieldService

Manages custom fields for tournaments, players, and teams.

| Method | Description |
|--------|-------------|
| `all(string $targetType, array $filters = [])` | Get all custom fields by target type |
| `find(string $id)` | Get a specific custom field |
| `create(array $data)` | Create a new custom field |
| `update(string $id, array $data)` | Update an existing custom field |
| `delete(string $id)` | Delete a custom field |
| `byTournament(string $tournamentId, string $targetType)` | Get custom fields for a tournament by target type |
| `playerFields(array $filters = [])` | Get all player custom fields |
| `teamFields(array $filters = [])` | Get all team custom fields |
| `teamPlayerFields(array $filters = [])` | Get all team player custom fields |
| `createPlayerField(string $tournamentId, string $machineName, string $label, string $type, array $additionalData = [])` | Create a custom field for players |
| `createTeamField(string $tournamentId, string $machineName, string $label, string $type, array $additionalData = [])` | Create a custom field for teams |
| `createTeamPlayerField(string $tournamentId, string $machineName, string $label, string $type, array $additionalData = [])` | Create a custom field for team players |
| `setVisibility(string $id, bool $isPublic)` | Set custom field visibility |
| `setRequired(string $id, bool $isRequired)` | Set whether custom field is required |
| `setPosition(string $id, int $position)` | Set custom field display position |
| `setDefaultValue(string $id, $defaultValue)` | Set custom field default value |

## DisciplineService

Manages game disciplines (e.g., CS:GO, League of Legends).

| Method | Description |
|--------|-------------|
| `all()` | Get all available disciplines |
| `find(string $id)` | Get a specific discipline by ID |
| `findByShortname(string $shortname)` | Find discipline by its shortname |
| `findByName(string $name)` | Find discipline by its full name |
| `findByPlatform(string $platform)` | Get all disciplines for a specific platform |

## GroupService

Manages tournament groups within stages.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all groups |
| `find(string $id)` | Get a specific group |
| `byTournament(string $tournamentId, array $filters = [])` | Get groups for a tournament |
| `byStage(string $stageId, array $filters = [])` | Get groups for a stage |
| `byStageNumber(int $stageNumber, array $filters = [])` | Get groups by stage number |
| `byTournamentAndStage(string $tournamentId, string $stageId, array $filters = [])` | Get groups by tournament and stage |
| `byNumber(int $groupNumber, array $filters = [])` | Get groups by group number |
| `open(array $filters = [])` | Get all open groups |
| `closed(array $filters = [])` | Get all closed groups |
| `getSettings(Group $group)` | Get group settings |
| `getMatchSettings(Group $group)` | Get match settings for the group |
| `getMatchFormat(Group $group)` | Get match format for the group |

## MatchGameService

Manages individual games within matches.

| Method | Description |
|--------|-------------|
| `allForMatch(string $matchId)` | Get all games for a match |
| `find(string $matchId, int $number)` | Get a specific game by match and game number |
| `update(string $matchId, int $number, array $data)` | Update game data |
| `updateStatus(string $matchId, int $number, ?string $status = null)` | Update game status |
| `updateResult(string $matchId, int $number, array $opponents)` | Update game result |
| `setCompleted(string $matchId, int $number)` | Mark game as completed |
| `setRunning(string $matchId, int $number)` | Mark game as running |
| `setPending(string $matchId, int $number)` | Mark game as pending |
| `updateProperties(string $matchId, int $number, array $properties)` | Update game properties |
| `updateOpponentProperties(string $matchId, int $gameNumber, int $opponentNumber, array $properties)` | Update opponent-specific properties |
| `getCompletedGames(string $matchId)` | Get all completed games for a match |
| `getPendingGames(string $matchId)` | Get all pending games for a match |
| `getRunningGames(string $matchId)` | Get all running games for a match |

## MatchReportService

Manages match reports and disputes.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all match reports |
| `find(string $id)` | Get a specific match report |
| `create(array $data)` | Create a new match report |
| `update(string $id, array $data)` | Update a match report |
| `byTournament(string $tournamentId, array $filters = [])` | Get reports for a tournament |
| `byMatch(string $matchId, array $filters = [])` | Get reports for a match |
| `byParticipant(string $participantId, array $filters = [])` | Get reports by participant |
| `byUser(string $userId, array $filters = [])` | Get reports by user |
| `byTeam(string $teamId, array $filters = [])` | Get reports by team |
| `byCustomUserIdentifier(string $customUserIdentifier, array $filters = [])` | Get reports by custom user identifier |
| `byType($types, array $filters = [])` | Get reports by type(s) |
| `closed(array $filters = [])` | Get closed reports |
| `open(array $filters = [])` | Get open reports |
| `reports(array $filters = [])` | Get report-type reports only |
| `disputes(array $filters = [])` | Get dispute-type reports only |
| `createReport(string $matchId, string $participantId, array $opponents, ?string $note = null, ?string $userId = null, ?string $customUserIdentifier = null)` | Create a match report |
| `createDispute(string $matchId, string $participantId, array $opponents, ?string $note = null, ?string $userId = null, ?string $customUserIdentifier = null)` | Create a match dispute |
| `close(string $id)` | Close a report |
| `addNote(string $id, string $note)` | Add a note to a report |

## MatchService

Manages tournament matches.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all matches |
| `find(string $id)` | Get a specific match |
| `update(string $id, array $data)` | Update match data |
| `byTournament(string $tournamentId, array $filters = [])` | Get matches for a tournament |
| `byStage(string $stageId, array $filters = [])` | Get matches for a stage |
| `byGroup(string $groupId, array $filters = [])` | Get matches for a group |
| `byRound(string $roundId, array $filters = [])` | Get matches for a round |
| `byParticipant(string $participantId, array $filters = [])` | Get matches for a participant |
| `byStatus($statuses, array $filters = [])` | Get matches by status(es) |
| `scheduled(array $filters = [])` | Get scheduled matches |
| `scheduledBefore(string $datetime, array $filters = [])` | Get matches scheduled before a date |
| `scheduledAfter(string $datetime, array $filters = [])` | Get matches scheduled after a date |
| `playedBefore(string $datetime, array $filters = [])` | Get matches played before a date |
| `playedAfter(string $datetime, array $filters = [])` | Get matches played after a date |
| `upcoming(array $filters = [])` | Get upcoming matches |
| `ongoing(array $filters = [])` | Get ongoing matches |
| `completed(array $filters = [])` | Get completed matches |
| `updateResult(string $id, array $opponents)` | Update match result |
| `schedule(string $id, string $datetime)` | Schedule a match |
| `addNotes(string $id, ?string $publicNote = null, ?string $privateNote = null)` | Add notes to a match |

## ParticipantService

Manages tournament participants.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all participants |
| `find(string $id)` | Get a specific participant |
| `create(array $data)` | Create a new participant |
| `update(string $id, array $data)` | Update participant data |
| `delete(string $id)` | Delete a participant |

## RankingService

Manages tournament rankings.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all ranking items |
| `byTournament(string $tournamentId, array $filters = [])` | Get rankings for a tournament |
| `byStage(string $stageId, array $filters = [])` | Get rankings for a stage |
| `byStageNumber(int $stageNumber, array $filters = [])` | Get rankings by stage number |
| `byGroup(string $groupId, array $filters = [])` | Get rankings for a group |
| `byGroupNumber(int $groupNumber, array $filters = [])` | Get rankings by group number |
| `byParticipant(string $participantId, array $filters = [])` | Get rankings for a participant |
| `byUser(string $userId, array $filters = [])` | Get rankings by user |
| `byTeam(string $teamId, array $filters = [])` | Get rankings by team |
| `byCustomUserIdentifier(string $customUserIdentifier, array $filters = [])` | Get rankings by custom identifier |
| `byRankRange(int $minRank, int $maxRank, array $filters = [])` | Get rankings within a rank range |
| `byTournamentAndStage(string $tournamentId, string $stageId, array $filters = [])` | Get rankings by tournament and stage |
| `byTournamentAndGroup(string $tournamentId, string $groupId, array $filters = [])` | Get rankings by tournament and group |
| `getTopRanked(array $filters, int $count = 3)` | Get top N ranked participants |
| `getTopRankedInTournament(string $tournamentId, int $count = 3)` | Get top N in a tournament |
| `getTopRankedInStage(string $tournamentId, string $stageId, int $count = 3)` | Get top N in a stage |
| `getTopRankedInGroup(string $tournamentId, string $groupId, int $count = 3)` | Get top N in a group |

## RegistrationService

Manages tournament registrations.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all registrations |
| `find(string $id)` | Get a specific registration |
| `create(array $data, bool $ignoreRequiredFields = false)` | Create a new registration |
| `update(string $id, array $data, bool $ignoreRequiredFields = false)` | Update registration data |
| `delete(string $id)` | Delete a registration |
| `byTournament(string $tournamentId, array $filters = [])` | Get registrations for a tournament |
| `byStatus($statuses, array $filters = [])` | Get registrations by status(es) |
| `pending(array $filters = [])` | Get pending registrations |
| `accepted(array $filters = [])` | Get accepted registrations |
| `refused(array $filters = [])` | Get refused registrations |
| `cancelled(array $filters = [])` | Get cancelled registrations |
| `byUser(string $userId, array $filters = [])` | Get registrations by user |
| `byTeam(string $teamId, array $filters = [])` | Get registrations by team |
| `byCustomUserIdentifier(string $customIdentifier, array $filters = [])` | Get registrations by custom identifier |
| `accept(string $id)` | Accept a registration |
| `refuse(string $id)` | Refuse a registration |
| `cancel(string $id)` | Cancel a registration |
| `createPlayerRegistration(array $data, bool $ignoreRequiredFields = false)` | Create a player registration |
| `createTeamRegistration(array $data, bool $ignoreRequiredFields = false)` | Create a team registration |

## RoundService

Manages tournament rounds within groups.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all rounds |
| `find(string $id)` | Get a specific round |
| `byTournament(string $tournamentId, array $filters = [])` | Get rounds for a tournament |
| `byStage(string $stageId, array $filters = [])` | Get rounds for a stage |
| `byStageNumber(int $stageNumber, array $filters = [])` | Get rounds by stage number |
| `byGroup(string $groupId, array $filters = [])` | Get rounds for a group |
| `byGroupNumber(int $groupNumber, array $filters = [])` | Get rounds by group number |
| `byTournamentStageAndGroup(string $tournamentId, string $stageId, string $groupId, array $filters = [])` | Get rounds by tournament, stage and group |
| `byNumber(int $roundNumber, array $filters = [])` | Get rounds by round number |
| `open(array $filters = [])` | Get open rounds |
| `closed(array $filters = [])` | Get closed rounds |
| `getSettings(Round $round)` | Get round settings |
| `getMatchSettings(Round $round)` | Get match settings for the round |
| `getMatchFormat(Round $round)` | Get match format for the round |

## SponsorService

Manages tournament sponsors.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all sponsors |
| `find(string $id)` | Get a specific sponsor |
| `create(array $data)` | Create a new sponsor |
| `update(string $id, array $data)` | Update sponsor data |
| `delete(string $id)` | Delete a sponsor |
| `byTournament(string $tournamentId)` | Get sponsors for a tournament |
| `createForTournament(string $tournamentId, string $name, string $logoId, ?string $website = null, int $position = 0)` | Create sponsor for a specific tournament |
| `updateName(string $id, string $name)` | Update sponsor name |
| `updateWebsite(string $id, ?string $website = null)` | Update sponsor website |
| `updatePosition(string $id, int $position)` | Update sponsor display position |
| `updateLogo(string $id, string $logoId)` | Update sponsor logo |
| `reorder(array $sponsorIds)` | Reorder multiple sponsors |

## StageService

Manages tournament stages.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all stages |
| `find(string $id)` | Get a specific stage |
| `byTournament(string $tournamentId)` | Get stages for a tournament |
| `create(array $data)` | Create a new stage |
| `update(string $id, array $data)` | Update stage data |
| `delete(string $id)` | Delete a stage |
| `seedParticipants(string $stageId, array $participantIds, string $method = 'manual')` | Seed participants into stage slots |
| `getBracket(string $stageId)` | Get bracket structure for the stage |
| `start(string $stageId)` | Start the stage (change status to running) |

## StandingService

Manages tournament standings.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all standing items |
| `find(string $id)` | Get a specific standing item |
| `create(array $data)` | Create a new standing item |
| `update(string $id, array $data)` | Update standing data |
| `delete(string $id)` | Delete a standing item |
| `byTournament(string $tournamentId, array $filters = [])` | Get standings for a tournament |
| `byParticipant(string $participantId, array $filters = [])` | Get standings for a participant |
| `byUser(string $userId, array $filters = [])` | Get standings by user |
| `byTeam(string $teamId, array $filters = [])` | Get standings by team |
| `byCustomUserIdentifier(string $customUserIdentifier, array $filters = [])` | Get standings by custom identifier |
| `byRankRange(int $minRank, int $maxRank, array $filters = [])` | Get standings within a rank range |
| `createForParticipant(string $tournamentId, string $participantId, int $rank)` | Create standing for a participant |
| `updateRank(string $id, int $rank)` | Update standing rank |
| `getTopRanked(string $tournamentId, int $count = 3)` | Get top N ranked participants |

## TournamentService

Manages tournaments.

| Method | Description |
|--------|-------------|
| `all(array $filters = [])` | Get all tournaments |
| `find(string $id)` | Get a specific tournament |
| `create(array $data)` | Create a new tournament |
| `update(string $id, array $data)` | Update tournament data |
| `delete(string $id)` | Delete a tournament |

## WebhookService

Manages webhooks and webhook subscriptions.

| Method | Description |
|--------|-------------|
| `all()` | Get all webhooks |
| `find(string $id)` | Get a specific webhook |
| `create(string $name, string $url, bool $enabled = true)` | Create a new webhook |
| `update(string $id, array $data)` | Update webhook data |
| `delete(string $id)` | Delete a webhook |
| `subscriptions(string $webhookId)` | Get all subscriptions for a webhook |
| `findSubscription(string $webhookId, string $subscriptionId)` | Get a specific subscription |
| `createSubscription(string $webhookId, string $eventName, string $scope, string\|null $scopeId)` | Create a new subscription |
| `updateSubscription(string $webhookId, string $subscriptionId, array $data)` | Update subscription data |
| `deleteSubscription(string $webhookId, string $subscriptionId)` | Delete a subscription |

---

## Usage Example

```php
// Access services through the Toornament facade
use ServNX\Toornament\Facades\Toornament;

// Get all tournaments
$tournaments = Toornament::tournaments()->all();

// Get matches for a specific tournament
$matches = Toornament::matches()->byTournament($tournamentId);

// Update match result
$match = Toornament::matches()->updateResult($matchId, [
    ['score' => 2],
    ['score' => 1]
]);
```