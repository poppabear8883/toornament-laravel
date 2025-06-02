# Laratoor Development Guidelines
- Refer to the Context directory for the context of this project.
- Files prefixed with `Toor-` are OpenAPI specifications for Toornament API endpoints.

## Build/Configuration Instructions

### Installation

1. Install the package via Composer:
   ```bash
   composer require servnx/toornament-laravel
   ```

2. Publish the configuration file:
   ```bash
   php artisan vendor:publish --provider="ServNX\Toornament\ToornamentServiceProvider" --tag="config"
   ```

3. Add your Toornament API credentials to your `.env` file:
   ```
   TOORNAMENT_API_KEY=your-api-key
   TOORNAMENT_CLIENT_ID=your-client-id
   TOORNAMENT_CLIENT_SECRET=your-client-secret
   TOORNAMENT_REDIRECT_URI=your-redirect-uri
   ```

### Configuration

The package configuration is stored in `config/toornament.php`. The main configuration options are:

- `api_key`: Your Toornament API key
- `oauth`: OAuth2 credentials (client_id, client_secret, redirect_uri)
- `base_url`: The base URL for API requests
- `oauth_token_url`: The URL for retrieving OAuth tokens
- `scopes`: Mapping of API sections to required OAuth scopes

## Testing Information

### Setting Up Testing Environment

1. Create a PHPUnit test directory structure:
   ```bash
   mkdir -p tests/Unit tests/Feature
   ```

2. Create a PHPUnit configuration file (`phpunit.xml`) in the project root:
   ```xml
   <?xml version="1.0" encoding="UTF-8"?>
   <phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
            bootstrap="vendor/autoload.php"
            colors="true">
       <testsuites>
           <testsuite name="Unit">
               <directory suffix="Test.php">./tests/Unit</directory>
           </testsuite>
           <testsuite name="Feature">
               <directory suffix="Test.php">./tests/Feature</directory>
           </testsuite>
       </testsuites>
       <php>
           <env name="APP_ENV" value="testing"/>
       </php>
   </phpunit>
   ```

3. Add PHPUnit to your development dependencies:
   ```bash
   composer require --dev phpunit/phpunit
   ```

4. Create a test configuration file for Toornament API credentials:
   ```bash
   cp config/toornament.php tests/config/toornament.php
   ```
   
   Then modify the test configuration to use environment variables or test-specific values.

### Writing Tests

#### Unit Tests

Unit tests should focus on testing individual components in isolation. For service classes, you should mock the HTTP client to avoid making actual API calls.

Example unit test for TournamentService:

```php
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
```

#### Feature Tests

Feature tests should test the integration between components. For API clients, you can use mock HTTP responses to simulate API calls.

### Running Tests

Run all tests:
```bash
./vendor/bin/phpunit
```

Run specific test suite:
```bash
./vendor/bin/phpunit --testsuite Unit
```

Run specific test file:
```bash
./vendor/bin/phpunit tests/Unit/TournamentServiceTest.php
```

## Additional Development Information

### Code Style

This project follows PSR-12 coding standards. You can use PHP_CodeSniffer to check your code:

```bash
composer require --dev squizlabs/php_codesniffer
./vendor/bin/phpcs --standard=PSR12 src/
```

### Service Structure

The package is organized around service classes that handle different aspects of the Toornament API:

- Each service class extends `BaseToornamentService`
- Services are registered in the `ToornamentServiceProvider`
- Services can be accessed through the `Toornament` facade

### Adding New Services

1. Create a new service class in the `src/Services` directory
2. Extend the `BaseToornamentService` class
3. Define the endpoint, unit, and scope properties
4. Implement the necessary methods
5. Register the service in the `ToornamentServiceProvider`

Example:
```php
// src/Services/NewService.php
namespace ServNX\Toornament\Services;

class NewService extends BaseToornamentService
{
    protected $endpoint = 'new-endpoint';
    protected $unit = 'new-units';
    protected $scope = 'required:scope';
    
    // Implement methods
}

// In ToornamentServiceProvider.php, add to $services array:
'new_service' => \ServNX\Toornament\Services\NewService::class,
```

### Error Handling

The package uses Guzzle for HTTP requests, which throws exceptions for HTTP errors. You should handle these exceptions in your application code:

```php
try {
    $tournament = Toornament::tournament()->find('123456789');
} catch (\GuzzleHttp\Exception\ClientException $e) {
    // Handle 4xx errors
} catch (\GuzzleHttp\Exception\ServerException $e) {
    // Handle 5xx errors
} catch (\Exception $e) {
    // Handle other exceptions
}
```

### Debugging

For debugging API requests, you can enable Guzzle's debug option in your application code:

```php
$client = app('toornament')->getClient();
$client->setDebug(true);
```

This will log all requests and responses to the Laravel log file.