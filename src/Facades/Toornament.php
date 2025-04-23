<?php

namespace ServNX\Toornament\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ServNX\Toornament\Services\TournamentService tournament()
 * @method static \ServNX\Toornament\Services\ParticipantService participant()
 * @method static \ServNX\Toornament\Services\MatchService match()
 * @method static \ServNX\Toornament\Services\RegistrationService registration()
 * @method static \ServNX\Toornament\Services\DisciplineService discipline()
 * @method static \ServNX\Toornament\Services\StageService stage()
 * @method static \ServNX\Toornament\Services\MatchReportService matchReport()
 * @method static \ServNX\Toornament\Services\MatchGameService matchGame()
 * @method static \ServNX\Toornament\Services\GroupService group()
 * @method static \ServNX\Toornament\Services\BracketService bracket()
 * @method static \ServNX\Toornament\Services\SponsorService sponsor()
 * @method static \ServNX\Toornament\Services\RoundService round()
 * @method static \ServNX\Toornament\Services\RankingService ranking()
 * @method static \ServNX\Toornament\Services\CustomFieldService customField()
 * @method static \ServNX\Toornament\Services\WebhookService webhook()
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