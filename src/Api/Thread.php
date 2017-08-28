<?php

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\Model\ThreadControl;
use Kerox\Messenger\Request\ThreadRequest;
use Kerox\Messenger\Response\ThreadResponse;

class Thread extends AbstractApi
{
    /**
     * @var null|\Kerox\Messenger\Api\Thread
     */
    private static $_instance;

    /**
     * Send constructor.
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
     * @return \Kerox\Messenger\Api\Thread
     */
    public static function getInstance(string $pageToken, ClientInterface $client): Thread
    {
        if (self::$_instance === null) {
            self::$_instance = new self($pageToken, $client);
        }

        return self::$_instance;
    }

    /**
     * @param \Kerox\Messenger\Model\ThreadControl $threadControl
     *
     * @return \Kerox\Messenger\Response\ThreadResponse
     */
    public function pass(ThreadControl $threadControl): ThreadResponse
    {
        $request = new ThreadRequest($this->pageToken, $threadControl);
        $response = $this->client->post('me/pass_thread_control', $request->build());

        return new ThreadResponse($response);
    }

    /**
     * @param \Kerox\Messenger\Model\ThreadControl $threadControl
     *
     * @return \Kerox\Messenger\Response\ThreadResponse
     */
    public function take(ThreadControl $threadControl): ThreadResponse
    {
        $request = new ThreadRequest($this->pageToken, $threadControl);
        $response = $this->client->post('me/take_thread_control', $request->build());

        return new ThreadResponse($response);
    }
}
