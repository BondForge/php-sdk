<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BondForge\Sdk\BondForgeClient;
use BondForge\Sdk\Generated\Model\BondBondWrite;

$client = BondForgeClient::withApiKeys('key', 'secret');

echo "Creating a new bond...\n";

$bondApi = $client->bonds();

$newBond = new BondBondWrite();
$newBond->setAmount(5000.00);
$newBond->setDefendant('/api/v1/defendants/123');
$newBond->setCourt('/api/v1/courts/456');

try {
    $result = $bondApi->apiBondsPost($newBond);
    echo "Bond created successfully! ID: " . $result->getId() . "\n";
} catch (\BondForge\Sdk\Exception\ApiException $e) {
    echo "Failed to create bond: " . $e->getMessage() . "\n";
    print_r($e->getResponseBody());
}
