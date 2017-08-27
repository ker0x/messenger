<?php

namespace Kerox\Messenger\Request;

class WebhookRequest extends AbstractRequest
{
    /**
     * WebhookRequest constructor.
     *
     * @param string $pageToken
     */
    public function __construct(string $pageToken)
    {
        parent::__construct($pageToken);
    }

    protected function buildHeaders()
    {
    }

    protected function buildBody()
    {
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        return parent::buildQuery();
    }
}
