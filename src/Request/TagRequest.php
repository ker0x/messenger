<?php

namespace Kerox\Messenger\Request;

class TagRequest extends AbstractRequest
{
    /**
     * TagRequest constructor.
     *
     * @param string $pageToken
     */
    public function __construct(string $pageToken)
    {
        parent::__construct($pageToken);
    }

    protected function buildHeaders(): void
    {
    }

    protected function buildBody(): void
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
