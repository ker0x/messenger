<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Request\TagRequest;
use Kerox\Messenger\Response\TagResponse;

class Tag extends AbstractApi
{
    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @return \Kerox\Messenger\Response\TagResponse
     */
    public function get(): TagResponse
    {
        $request = new TagRequest('page_message_tags');
        $response = $this->client->sendRequest($request->build());

        return new TagResponse($response);
    }
}
