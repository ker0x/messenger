<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Request\TagRequest;
use Kerox\Messenger\Response\TagResponse;

class Tag extends AbstractApi
{
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
