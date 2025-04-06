<?php

namespace ServNX\Toornament\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ServNX\Toornament\Services\TournamentService tournament()
 * @method static \ServNX\Toornament\Services\ParticipantService participant()
 * @method static \ServNX\Toornament\Services\ToornamentMatchService match()
 * @method static \ServNX\Toornament\Services\RegistrationService registration()
 * @method static \ServNX\Toornament\Services\DisciplineService discipline()
 * @method static \ServNX\Toornament\Http\ToornamentClient getClient()
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