<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Psr\Http\Client\ClientInterface;

abstract class AbstractApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * AbstractApi constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
}
