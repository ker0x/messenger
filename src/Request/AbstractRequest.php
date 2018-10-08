<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

abstract class AbstractRequest
{
    /**
     * @var RequestInterface
     */
    protected $origin;

    /**
     * AbstractRequest constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->origin = new Request('get', Uri::fromParts(['path' => $path]));
    }

    /**
     * @param string|null $method
     *
     * @return RequestInterface
     */
    abstract public function build(?string $method = null): RequestInterface;
}
