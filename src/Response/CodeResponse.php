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

    /**
     * @param array $response
     */
    protected function parseResponse(array $response): void
    {
        $this->uri = $response[self::URI] ?? null;
    }

    /**
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }
}
