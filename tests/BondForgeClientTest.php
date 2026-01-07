<?php

namespace BondForge\Sdk\Tests;

use BondForge\Sdk\BondForgeClient;
use PHPUnit\Framework\TestCase;

class BondForgeClientTest extends TestCase
{
    public function testWithApiKeys()
    {
        $client = BondForgeClient::withApiKeys('my-key', 'my-secret');
        $this->assertInstanceOf(BondForgeClient::class, $client);
    }

    public function testWithJwt()
    {
        $client = BondForgeClient::withJwt('my-jwt');
        $this->assertInstanceOf(BondForgeClient::class, $client);
    }
}
