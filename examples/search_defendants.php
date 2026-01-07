<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BondForge\Sdk\BondForgeClient;
use BondForge\Sdk\Pagination\HydraIterator;

// Initialize client with API Keys
$client = BondForgeClient::withApiKeys(
    'your-api-key',
    'your-api-secret',
    ['baseUrl' => 'https://api.bondforge.com']
);

echo "Searching for defendants with last name 'Smith'...\n";

$defendantApi = $client->defendants();

// Use the HydraIterator for easy pagination
// The first argument to the closure is the page number
$defendants = new HydraIterator(function($page) use ($defendantApi) {
    return $defendantApi->apiDefendantsGetCollection(
        page: $page,
        lastName: 'Smith'
    );
});

foreach ($defendants as $defendant) {
    echo sprintf("- %s %s (ID: %s)\n", 
        $defendant->getFirstName(), 
        $defendant->getLastName(),
        $defendant->getId()
    );
}
