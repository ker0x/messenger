<?php

namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

class ThreadResponse extends AbstractResponse
{
    private const SUCCESS = 'success';

    /**
     * @var bool
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
    protected function parseResponse(array $response): void
    {
        $this->success = $response[self::SUCCESS] ?? false;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success === true;
    }
}
