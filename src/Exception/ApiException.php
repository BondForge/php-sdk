<?php

declare(strict_types=1);

namespace BondForge\Sdk\Exception;

use BondForge\Sdk\Generated\ApiException as GeneratedApiException;
use Throwable;

final class ApiException extends BondForgeException
{
    private ?int $httpStatusCode;
    private $responseBody;
    private array $responseHeaders;

    public function __construct(
        string $message = '',
        int $code = 0,
        array $responseHeaders = [],
        $responseBody = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
        $this->httpStatusCode  = $code;
        $this->responseHeaders = $responseHeaders;
        $this->responseBody    = $responseBody;
    }

    public static function fromGenerated(GeneratedApiException $e) : self
    {
        return new self(
            $e->getMessage(),
            $e->getCode(),
            $e->getResponseHeaders() ?? [],
            $e->getResponseBody(),
            $e,
        );
    }

    public function getHttpStatusCode() : ?int
    {
        return $this->httpStatusCode;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    public function getResponseHeaders() : array
    {
        return $this->responseHeaders;
    }

    public function getRequestId() : ?string
    {
        $headers = array_change_key_case($this->responseHeaders, CASE_LOWER);

        return $headers['x-request-id'][0] ?? $headers['x-correlation-id'][0] ?? null;
    }
}
