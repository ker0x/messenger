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

    /**
     * @return null
     */
    protected function buildHeaders()
    {
        return;
    }

    /**
     * @return null
     */
    protected function buildBody()
    {
        return;
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        return parent::buildQuery();
    }
}
