<?php

namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

class WebhookResponse extends AbstractResponse
{
    const SUCCESS = 'success';

    /**
     * @var null|bool
     */
    protected $success;

    /**
     * Webhook constructor.
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
        $this->setSuccess($response);
    }

    /**
     * @return null|bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param array $response
     */
    private function setSuccess(array $response)
    {
        if (isset($response[self::SUCCESS])) {
            $this->success = $response[self::SUCCESS];
        }
    }
}
