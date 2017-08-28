<?php

namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

class ThreadResponse extends AbstractResponse
{
    const SUCCESS = 'success';

    /**
     * @var null|bool
     */
    protected $success;

    /**
     * ThreadResponse constructor.
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
        $this->success = $response[self::SUCCESS] ?? null;
    }

    /**
     * @return null|bool
     */
    public function isSuccess(): bool
    {
        return $this->success === true;
    }
}
