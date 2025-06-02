<?php

namespace ServNX\Toornament;

use Illuminate\Support\ServiceProvider;
use ServNX\Toornament\Http\ToornamentClient;

class ToornamentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/toornament.php' => config_path('toornament.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__.'/../config/toornament.php', 'toornament');

        // Register the main class to use with the facade
        $this->app->singleton('toornament', function ($app) {
            return new Toornament(new ToornamentClient($app));
        });

        // Register services
        $this->registerServices();
    }

    /**
     * Register service classes
     *
     * @return void
     */
    protected function registerServices()
    {
        $services = [
            'tournament' => \ServNX\Toornament\Services\TournamentService::class,
            'participant' => \ServNX\Toornament\Services\ParticipantService::class,
            'match' => \ServNX\Toornament\Services\MatchService::class,
            'registration' => \ServNX\Toornament\Services\RegistrationService::class,
            'discipline' => \ServNX\Toornament\Services\DisciplineService::class,
            'custom_field' => \ServNX\Toornament\Services\CustomFieldService::class,
            'bracket' => \ServNX\Toornament\Services\BracketService::class,
            'group' => \ServNX\Toornament\Services\GroupService::class,
            'round' => \ServNX\Toornament\Services\RoundService::class,
            'sponsor' => \ServNX\Toornament\Services\SponsorService::class,
            'stage' => \ServNX\Toornament\Services\StageService::class,
            'standing' => \ServNX\Toornament\Services\StandingService::class,
            'match_report' => \ServNX\Toornament\Services\MatchReportService::class,
            'match_game' => \ServNX\Toornament\Services\MatchGameService::class,
            'ranking' => \ServNX\Toornament\Services\RankingService::class,
            'webhook' => \ServNX\Toornament\Services\WebhookService::class,
            'placement' => \ServNX\Toornament\Services\PlacementService::class,
        ];

        foreach ($services as $key => $class) {
            $this->app->singleton("toornament.{$key}", function ($app) use ($class) {
                return new $class($app->make('toornament'));
            });
        }
    }
}