<?php

declare(strict_types=1);

namespace Kerox\Messenger\Response;

use Psr\Http\Message\ResponseInterface;

class CodeResponse extends AbstractResponse
{
    private const URI = 'uri';

    /**
     * @var null|string
     */
    protected $uri;

    /**
     * CodeResponse constructor.
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
