<?php

namespace BondForge\Sdk;

use BondForge\Sdk\Exception\ApiException;
use BondForge\Sdk\Generated\Api\AgencyApi;
use BondForge\Sdk\Generated\Api\AgentApi;
use BondForge\Sdk\Generated\Api\BalanceApi;
use BondForge\Sdk\Generated\Api\BondApi;
use BondForge\Sdk\Generated\Api\BondCommentApi;
use BondForge\Sdk\Generated\Api\BoundOverApi;
use BondForge\Sdk\Generated\Api\ChargeApi;
use BondForge\Sdk\Generated\Api\CourtApi;
use BondForge\Sdk\Generated\Api\CourtTypeApi;
use BondForge\Sdk\Generated\Api\DefendantApi;
use BondForge\Sdk\Generated\Api\DefendantUDFApi;
use BondForge\Sdk\Generated\Api\FeatureFlagApi;
use BondForge\Sdk\Generated\Api\NotificationApi;
use BondForge\Sdk\Generated\Api\PaymentApi;
use BondForge\Sdk\Generated\Api\UDFGroupApi;
use BondForge\Sdk\Generated\Api\UDFTypeApi;
use BondForge\Sdk\Generated\Configuration;
use BondForge\Sdk\Generated\ApiException as GeneratedApiException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class BondForgeClient
{
    private Configuration $config;
    private ClientInterface $httpClient;

    public function __construct(Configuration $config, ?ClientInterface $httpClient = null)
    {
        $this->config = $config;
        $this->httpClient = $httpClient ?? new Client();
    }

    public static function withApiKeys(string $apiKey, string $apiSecret, array $options = []): self
    {
        $config = new Configuration();
        $config->setApiKey('X-API-KEY', $apiKey);
        $config->setApiKey('X-API-SECRET', $apiSecret);

        return self::createFromOptions($config, $options);
    }

    public static function withJwt(string $jwt, array $options = []): self
    {
        $config = new Configuration();
        $config->setAccessToken($jwt);

        return self::createFromOptions($config, $options);
    }

    private static function createFromOptions(Configuration $config, array $options): self
    {
        if (isset($options['baseUrl'])) {
            $config->setHost($options['baseUrl']);
        }
        if (isset($options['userAgent'])) {
            $config->setUserAgent($options['userAgent']);
        }

        $guzzleOptions = [];
        if (isset($options['timeout'])) {
            $guzzleOptions['timeout'] = $options['timeout'];
        }
        // Retries could be implemented via a handler stack if needed, 
        // but for simplicity we'll keep it basic for now unless requested.

        $httpClient = new Client($guzzleOptions);

        return new self($config, $httpClient);
    }

    /**
     * Helper to wrap generated API calls and catch exceptions
     */
    private function call(callable $fn)
    {
        try {
            return $fn();
        } catch (GeneratedApiException $e) {
            throw ApiException::fromGenerated($e);
        }
    }

    public function agencies(): AgencyApi
    {
        return new AgencyApi($this->httpClient, $this->config);
    }

    public function agents(): AgentApi
    {
        return new AgentApi($this->httpClient, $this->config);
    }

    public function balances(): BalanceApi
    {
        return new BalanceApi($this->httpClient, $this->config);
    }

    public function bonds(): BondApi
    {
        return new BondApi($this->httpClient, $this->config);
    }

    public function bondComments(): BondCommentApi
    {
        return new BondCommentApi($this->httpClient, $this->config);
    }

    public function boundOvers(): BoundOverApi
    {
        return new BoundOverApi($this->httpClient, $this->config);
    }

    public function charges(): ChargeApi
    {
        return new ChargeApi($this->httpClient, $this->config);
    }

    public function courts(): CourtApi
    {
        return new CourtApi($this->httpClient, $this->config);
    }

    public function courtTypes(): CourtTypeApi
    {
        return new CourtTypeApi($this->httpClient, $this->config);
    }

    public function defendants(): DefendantApi
    {
        return new DefendantApi($this->httpClient, $this->config);
    }

    public function defendantUDFs(): DefendantUDFApi
    {
        return new DefendantUDFApi($this->httpClient, $this->config);
    }

    public function featureFlags(): FeatureFlagApi
    {
        return new FeatureFlagApi($this->httpClient, $this->config);
    }

    public function notifications(): NotificationApi
    {
        return new NotificationApi($this->httpClient, $this->config);
    }

    public function payments(): PaymentApi
    {
        return new PaymentApi($this->httpClient, $this->config);
    }

    public function udfGroups(): UDFGroupApi
    {
        return new UDFGroupApi($this->httpClient, $this->config);
    }

    public function udfTypes(): UDFTypeApi
    {
        return new UDFTypeApi($this->httpClient, $this->config);
    }
}
