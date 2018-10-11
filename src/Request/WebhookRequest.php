<?php

declare(strict_types=1);

namespace Kerox\Messenger\Request;

use Psr\Http\Message\RequestInterface;

class WebhookRequest extends AbstractRequest
{
    /**
     * @param string|null $method
     *
     * @return RequestInterface
     */
    public function build(?string $method = null): RequestInterface
    {
        return $this->origin;
    }
}
