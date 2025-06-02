<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Toornament API credentials for testing
    |--------------------------------------------------------------------------
    |
    | Test-specific Toornament API key and OAuth2 credentials
    |
    */
    'api_key' => env('TEST_TOORNAMENT_API_KEY', 'test-api-key'),

    'oauth' => [
        'client_id' => env('TEST_TOORNAMENT_CLIENT_ID', 'test-client-id'),
        'client_secret' => env('TEST_TOORNAMENT_CLIENT_SECRET', 'test-client-secret'),
        'redirect_uri' => env('TEST_TOORNAMENT_REDIRECT_URI', 'test-redirect-uri'),
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