<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

class WebhookResponse extends AbstractResponse
{
    private const SUCCESS = 'success';

    /**
     * @var bool
     */
    protected $success;

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
