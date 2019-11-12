<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

abstract class AbstractResponse
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * AbstractResponse constructor.
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        $this->parseResponse($this->decodeResponse($response));
    }

    private function decodeResponse(ResponseInterface $response): array
    {
        return json_decode((string) $response->getBody(), true);
    }

    abstract protected function parseResponse(array $response): void;

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
