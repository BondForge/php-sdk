<?php

declare(strict_types=1);

namespace BondForge\Sdk\Tests;

use BondForge\Sdk\BondForgeClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class BondForgeClientTest extends TestCase
{
    public function testWithApiKeys()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['token' => 'mock-bearer-token', 'expiresAt' => '2026-01-01T00:00:00Z'])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $bondForgeClient = BondForgeClient::withApiKeys('my-key', 'my-secret', ['httpClient' => $client]);
        $this->assertInstanceOf(BondForgeClient::class, $bondForgeClient);
        
        // Reflect to check if the token was set in config
        $reflection = new \ReflectionClass($bondForgeClient);
        $configProp = $reflection->getProperty('config');
        $configProp->setAccessible(true);
        $config = $configProp->getValue($bondForgeClient);
        
        $this->assertEquals('mock-bearer-token', $config->getAccessToken());
    }

    public function testWithJwt()
    {
        $client = BondForgeClient::withJwt('my-jwt');
        $this->assertInstanceOf(BondForgeClient::class, $client);
    }

    public function testNoApiKeyHeaders()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['token' => 'mock-bearer-token', 'expiresAt' => '2026-01-01T00:00:00Z'])),
            new Response(200, [], json_encode(['member' => []])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $bondForgeClient = BondForgeClient::withApiKeys('my-key', 'my-secret', ['httpClient' => $client]);
        
        // This call should NOT have X-API-KEY or X-API-SECRET headers
        $bondForgeClient->agencies()->apiAgenciesGetCollection();
        
        $request = $mock->getLastRequest();
        $this->assertFalse($request->hasHeader('X-API-KEY'));
        $this->assertFalse($request->hasHeader('X-API-SECRET'));
        $this->assertEquals('Bearer mock-bearer-token', $request->getHeaderLine('Authorization'));
    }
}
