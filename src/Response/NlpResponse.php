<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

class NlpResponse extends AbstractResponse
{
    private const SUCCESS = 'success';

    /**
     * @var bool
     */
    protected $success;

    protected function parseResponse(array $response): void
    {
        $this->success = $response[self::SUCCESS] ?? false;
    }

    public function isSuccess(): bool
    {
        return $this->success === true;
    }
}
