<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

class ProfileResponse extends AbstractResponse
{
    private const RESULT = 'result';

    /**
     * @var string|null
     */
    protected $result;

    /**
     * @param array $response
     */
    protected function parseResponse(array $response): void
    {
        $this->result = $response[self::RESULT] ?? null;
    }

    /**
     * @return string|null
     */
    public function getResult(): ?string
    {
        return $this->result;
    }
}
