<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Psr\Http\Message\RequestInterface;

class TagRequest extends AbstractRequest
{
    /**
     * @param string $method
     *
     * @return RequestInterface
     */
    public function build(string $method = 'post'): RequestInterface
    {
        return $this->origin;
    }
}
