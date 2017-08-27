<?php

namespace Kerox\Messenger\Request;

class InsightsRequest extends AbstractRequest
{
    /**
     * InsightsRequest constructor.
     *
     * @param string $pageToken
     */
    public function __construct($pageToken)
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
