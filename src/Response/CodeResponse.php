<?php

namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

class CodeResponse extends AbstractResponse
{
    const URI = 'uri';

    /**
     * @var null|string
     */
    protected $uri;

    /**
     * CodeResponse constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
    }

    /**
     * @param array $response
     */
    protected function parseResponse(array $response)
    {
        $this->uri = $response[self::URI] ?? null;
    }

    /**
     * @return null|string
     */
    public function getUri()
    {
        return $this->uri;
    }
}
