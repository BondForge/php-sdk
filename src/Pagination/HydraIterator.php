<?php

declare(strict_types=1);

namespace BondForge\Sdk\Pagination;

use BondForge\Sdk\Generated\Model\HydraCollectionBaseSchema;
use BondForge\Sdk\Generated\Model\HydraCollectionBaseSchemaAllOfView;
use Iterator;

final class HydraIterator implements Iterator
{
    private $apiClient;
    private string $method;
    private array $args;
    private int $currentIndex                             = 0;
    private ?HydraCollectionBaseSchema $currentCollection = null;
    private array $currentItems                           = [];
    private int $page                                     = 1;

    public function __construct(callable $apiCall, array $args = [])
    {
        $this->apiCall = $apiCall;
        $this->args    = $args;
    }

    private function fetchPage(int $page)
    {
        $args = $this->args;
        // Most collection endpoints in the generated client have a 'page' parameter.
        // We need to find where it is in the arguments.
        // For OpenAPI generated PHP client, collection methods usually take (page, ...)
        // or have page in the parameter list.

        // This is a bit tricky because the generated client methods have different signatures.
        // We'll assume the first argument is page if not specified otherwise,
        // or we expect the user to provide a closure.

        $response = ($this->apiCall)($page, ...$this->args);

        if ($response instanceof HydraCollectionBaseSchema) {
            $this->currentCollection = $response;
            // The actual items are in the 'member' property of the specific collection class,
            // but HydraCollectionBaseSchema is just the base.
            // The generated specific collection classes (like ApiAgenciesGetCollection200Response)
            // extend or use this.

            // Since we don't know the exact class, we use reflection or array access if available.
            if (method_exists($response, 'getMember')) {
                $this->currentItems = $response->getMember();
            } elseif (isset($response['member'])) {
                $this->currentItems = $response['member'];
            } else {
                $this->currentItems = [];
            }
        }
    }

    public function current() : mixed
    {
        return $this->currentItems[$this->currentIndex];
    }

    public function next() : void
    {
        $this->currentIndex++;
        if ($this->currentIndex >= count($this->currentItems)) {
            $view = $this->currentCollection ? $this->currentCollection->getView() : null;
            if ($view instanceof HydraCollectionBaseSchemaAllOfView && $view->getNext()) {
                $this->page++;
                $this->fetchPage($this->page);
                $this->currentIndex = 0;
            }
        }
    }

    public function key() : mixed
    {
        return ($this->page - 1) * 30 + $this->currentIndex; // Assuming default 30 items per page
    }

    public function valid() : bool
    {
        if ($this->currentCollection === null && $this->page === 1) {
            $this->fetchPage($this->page);
        }

        return isset($this->currentItems[$this->currentIndex]);
    }

    public function rewind() : void
    {
        $this->page         = 1;
        $this->currentIndex = 0;
        $this->fetchPage($this->page);
    }
}
