<?php

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\Request\TagRequest;
use Kerox\Messenger\Response\TagResponse;

class Tag extends AbstractApi
{
    /**
     * @var null|\Kerox\Messenger\Api\Tag
     */
    private static $_instance;

    /**
     * Tag constructor.
     *
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function __construct(string $pageToken, ClientInterface $client)
    {
        parent::__construct($pageToken, $client);
    }

    /**
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return \Kerox\Messenger\Api\Tag
     */
    public static function getInstance(string $pageToken, ClientInterface $client): self
    {
        if (self::$_instance === null) {
            self::$_instance = new self($pageToken, $client);
        }

        return self::$_instance;
    }

    /**
     * @return \Kerox\Messenger\Response\TagResponse
     */
    public function get(): TagResponse
    {
        $request = new TagRequest($this->pageToken);
        $response = $this->client->get('page_message_tags', $request->build());

        return new TagResponse($response);
    }
}
