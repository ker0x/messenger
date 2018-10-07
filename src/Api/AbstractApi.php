<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Psr\Http\Client\ClientInterface;

abstract class AbstractApi
{
    /**
     * @var string
     */
    protected $pageToken;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * AbstractApi constructor.
     *
     * @param string          $pageToken
     * @param ClientInterface $client
     */
    public function __construct(string $pageToken, ClientInterface $client)
    {
        $this->pageToken = $pageToken;
        $this->client = $client;
    }
}
