<?php

declare(strict_types=1);

namespace Kerox\Messenger\Http;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client extends \GuzzleHttp\Client implements ClientInterface
{
    /**
     * @param RequestInterface $request
     *
     * @throws ClientException
     *
     * @return ResponseInterface
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->send($request);
        } catch (GuzzleException $e) {
            throw new ClientException($e->getMessage(), $request, null, $e);
        }
    }
}
