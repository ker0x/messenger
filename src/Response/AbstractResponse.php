<?php
namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

abstract class AbstractResponse
{

    /**
     * AbstractResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->parseResponse($this->decodeResponse($response));
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return array
     */
    private function decodeResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody(), true);
    }

    /**
     * @param array $response
     * @return mixed
     */
    abstract protected function parseResponse(array $response);
}
