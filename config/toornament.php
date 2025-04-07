<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Toornament API credentials
    |--------------------------------------------------------------------------
    |
    | Your Toornament API key and OAuth2 credentials
    |
    */
    'api_key' => env('TOORNAMENT_API_KEY', ''),

    'oauth' => [
        'client_id' => env('TOORNAMENT_CLIENT_ID', ''),
        'client_secret' => env('TOORNAMENT_CLIENT_SECRET', ''),
        'redirect_uri' => env('TOORNAMENT_REDIRECT_URI', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Toornament API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for all API requests
    |
    */
    'base_url' => 'https://api.toornament.com/organizer/v2/',

    /*
    |--------------------------------------------------------------------------
    | OAuth Token URL
    |--------------------------------------------------------------------------
    |
    | The URL for retrieving OAuth tokens
    |
    */
    'oauth_token_url' => 'https://api.toornament.com/oauth/v2/token',

    /*
    |--------------------------------------------------------------------------
    | Scope Mapping
    |--------------------------------------------------------------------------
    |
    | Maps API sections to required OAuth scopes
    |
    */
    'scopes' => [
        'tournaments' => 'organizer:view',
        'tournament_admin' => 'organizer:admin',
        'tournament_delete' => 'organizer:delete',
        'participants' => 'organizer:participant',
        'matches' => 'organizer:result',
        'registrations' => 'organizer:registration',
        'disciplines' => '',  // No scope needed, just API key
        'placements' => 'organizer:placement',
        'custom_fields' => 'organizer:admin',
    ],
];