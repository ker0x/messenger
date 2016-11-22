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
