<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BondForge\Sdk\BondForgeClient;

// Initialize client with JWT
$client = BondForgeClient::withJwt(
    'your-jwt-token',
    ['baseUrl' => 'https://api.bondforge.net']
);

echo "Retrieving courts...\n";

$courtApi = $client->courts();

try {
    $courts = $courtApi->apiCourtsGetCollection(page: 1);
    
    foreach ($courts->getMember() as $court) {
        echo sprintf("- Room: %s, Judge: %s\n", 
            $court->getRoom(),
            $court->getJudge()
        );
    }
} catch (\BondForge\Sdk\Exception\ApiException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Status Code: " . $e->getHttpStatusCode() . "\n";
}
