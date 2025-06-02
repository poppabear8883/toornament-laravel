# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Overview

Laratoor is a Laravel package that provides a comprehensive wrapper for the Toornament esports API. It offers a clean, object-oriented interface for managing tournaments, participants, matches, and all other Toornament resources.

## Development Commands

### Testing
```bash
# Run all tests
vendor/bin/phpunit

# Run specific test file
vendor/bin/phpunit tests/Unit/TournamentServiceTest.php

# Run with coverage
vendor/bin/phpunit --coverage-html coverage
```

### Package Development
```bash
# Install dependencies
composer install

# Update autoload
composer dump-autoload
```

Note: The package currently lacks lint and code style commands. Consider adding them when requested.

## Architecture

### Service Layer Pattern
The package uses a service-oriented architecture:

1. **Entry Point**: `Toornament` class acts as a service locator
   - Dynamically routes method calls to appropriate services
   - Converts camelCase to snake_case for consistency
   - Example: `$toornament->tournaments()` returns `TournamentService`

2. **Service Classes**: Each API resource has a dedicated service
   - Located in `src/Services/`
   - All extend `BaseToornamentService`
   - Handle API operations for their resource type

3. **HTTP Layer**: `ToornamentClient` manages all API communication
   - Handles OAuth2 and API key authentication
   - Manages token lifecycle
   - Centralizes request/response handling

4. **Model Layer**: Typed model classes in `src/Models/`
   - Represent API responses as objects
   - Provide typed getters for data access
   - No setters - models are read-only representations

### Service Registration
All services are registered in `ToornamentServiceProvider`:
- Main `Toornament` class as singleton
- Individual services as singletons with injected client
- Configuration publishing for Laravel apps

### Authentication Flow
The package supports two authentication methods:
1. **API Key**: Simple key-based authentication
2. **OAuth2**: Full OAuth flow with token management
   - Automatic token refresh
   - Scope-based permissions

## Key Development Patterns

### Adding New Services
1. Create service class in `src/Services/` extending `BaseToornamentService`
2. Add corresponding model in `src/Models/`
3. Register service in `ToornamentServiceProvider`
4. Add method to `Toornament` class for access

### API Response Handling
- Services return arrays or model instances
- Use `ToornamentException` for API errors
- Models should implement `JsonSerializable` for easy serialization

### Testing Approach
- Unit tests for individual services
- Mock `ToornamentClient` for isolated testing
- Feature tests for integration scenarios

## Current Limitations

1. **Testing**: Minimal test coverage - only `TournamentServiceTest` exists
2. **Documentation**: API methods lack inline documentation
3. **Tooling**: No linting or code style enforcement
4. **Validation**: Limited input validation before API calls

## Important Files for Context

- `docs/tasks.md`: Comprehensive improvement roadmap with 72 prioritized tasks
- `Context/*.json`: API response examples for each resource type
- `config/toornament.php`: Configuration structure and available options