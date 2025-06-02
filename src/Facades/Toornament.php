<?php

namespace ServNX\Toornament\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ServNX\Toornament\Services\TournamentService tournaments()
 * @method static \ServNX\Toornament\Services\ParticipantService participants()
 * @method static \ServNX\Toornament\Services\MatchService matches()
 * @method static \ServNX\Toornament\Services\RegistrationService registrations()
 * @method static \ServNX\Toornament\Services\DisciplineService disciplines()
 * @method static \ServNX\Toornament\Services\StageService stages()
 * @method static \ServNX\Toornament\Services\MatchReportService match_reports()
 * @method static \ServNX\Toornament\Services\MatchGameService match_games()
 * @method static \ServNX\Toornament\Services\GroupService groups()
 * @method static \ServNX\Toornament\Services\BracketService brackets()
 * @method static \ServNX\Toornament\Services\SponsorService sponsors()
 * @method static \ServNX\Toornament\Services\RoundService rounds()
 * @method static \ServNX\Toornament\Services\RankingService rankings()
 * @method static \ServNX\Toornament\Services\CustomFieldService custom_fields()
 * @method static \ServNX\Toornament\Services\WebhookService webhooks()
 * @method static \ServNX\Toornament\Services\StandingService standings()
 * @method static \ServNX\Toornament\Services\PlacementService placements()
 *
 * @method static \ServNX\Toornament\Http\ToornamentClient getClient()
 *
 */
class Toornament extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'toornament';
    }
}