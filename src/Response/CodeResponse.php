<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

class CodeResponse extends AbstractResponse
{
    private const URI = 'uri';

    /**
     * @var string|null
     */
    protected $uri;

    protected function parseResponse(array $response): void
    {
        $this->uri = $response[self::URI] ?? null;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }
}
