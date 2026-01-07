# Contributing to BondForge PHP SDK

Thank you for your interest in contributing to the BondForge PHP SDK!

## Development Setup

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```

## Running Tests

We use PHPUnit for testing:
```bash
vendor/bin/phpunit
```

## Static Analysis

We use PHPStan:
```bash
vendor/bin/phpstan analyse src --level 5
```

## Code Style

We follow PSR-12. You can check the formatting with:
```bash
vendor/bin/php-cs-fixer fix src --dry-run
```

## Pull Request Process

1. Create a new branch for your feature or bugfix.
2. Ensure tests pass and code style is maintained.
3. Submit a PR to the `main` branch.
4. Provide a clear description of the changes.

## Security

If you discover a security vulnerability, please email support@bondforge.com.
