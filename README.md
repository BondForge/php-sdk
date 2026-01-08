# BondForge PHP SDK

Official PHP SDK for the [BondForge API](https://docs.bondforgehq.com/API/).

## Installation

```bash
composer require bondforge/bondforge-sdk-php
```

## Authentication

The SDK supports both API Key/Secret and JWT Bearer token authentication.

### API Key + Secret

```php
use BondForge\Sdk\BondForgeClient;

$client = BondForgeClient::withApiKeys(
    'your-api-key',
    'your-api-secret',
    ['baseUrl' => 'https://api.bondforge.net']
);
```

### JWT Bearer Token

```php
use BondForge\Sdk\BondForgeClient;

$client = BondForgeClient::withJwt(
    'your-jwt-token',
    ['baseUrl' => 'https://api.bondforge.net']
);
```

## Usage

### Simple Example

```php
$agencies = $client->agencies()->apiAgenciesGetCollection();
foreach ($agencies->getMember() as $agency) {
    echo $agency->getName();
}
```

### Pagination

The SDK provides a `HydraIterator` to easily traverse paginated results from Hydra-enabled endpoints.

```php
use BondForge\Sdk\Pagination\HydraIterator;

$defendants = new HydraIterator(function($page) use ($client) {
    return $client->defendants()->apiDefendantsGetCollection(page: $page);
});

foreach ($defendants as $defendant) {
    echo $defendant->getFirstName();
}
```

## Examples

See the `examples/` directory for more detailed examples:
- `search_defendants.php`
- `court_today.php`
- `create_bond.php`

## Error Handling

All API errors throw a `BondForge\Sdk\Exception\ApiException`.

```php
try {
    $client->bonds()->apiBondsIdGet('invalid-id');
} catch (\BondForge\Sdk\Exception\ApiException $e) {
    echo $e->getHttpStatusCode(); // 404
    echo $e->getMessage();
    echo $e->getRequestId(); // Correlation ID if available
}
```

## License

Apache-2.0
