<?php

namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

class ProfileResponse extends AbstractResponse
{
    const RESULT = 'result';

    /**
     * @var null|string
     */
    protected $result;

    /**
     * Thread constructor.
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
        $this->result = $response[self::RESULT] ?? null;
    }

    /**
     * @return null|string
     */
    public function getResult()
    {
        return $this->result;
    }
}
