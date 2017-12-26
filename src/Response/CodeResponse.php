<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

class CodeResponse extends AbstractResponse
{
    private const URI = 'uri';

    /**
     * @var null|string
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
     * @return null|string
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }
}
