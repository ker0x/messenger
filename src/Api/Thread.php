<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Model\ThreadControl;
use Kerox\Messenger\Request\ThreadRequest;
use Kerox\Messenger\Response\ThreadResponse;

class Thread extends AbstractApi
{
    /**
     * @param \Kerox\Messenger\Model\ThreadControl $threadControl
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Messenger\Response\ThreadResponse
     */
    public function pass(ThreadControl $threadControl): ThreadResponse
    {
        $request = new ThreadRequest('me/pass_thread_control', $threadControl);
        $response = $this->client->sendRequest($request->build());

        return new ThreadResponse($response);
    }

    /**
     * @param \Kerox\Messenger\Model\ThreadControl $threadControl
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Messenger\Response\ThreadResponse
     */
    public function take(ThreadControl $threadControl): ThreadResponse
    {
        $request = new ThreadRequest('me/take_thread_control', $threadControl);
        $response = $this->client->sendRequest($request->build());

        return new ThreadResponse($response);
    }

    /**
     * @param \Kerox\Messenger\Model\ThreadControl $threadControl
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Messenger\Response\ThreadResponse
     */
    public function request(ThreadControl $threadControl): ThreadResponse
    {
        $request = new ThreadRequest('me/request_thread_control', $threadControl);
        $response = $this->client->sendRequest($request->build());

        return new ThreadResponse($response);
    }
}
