<?php

namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\ThreadControl;

class ThreadRequest extends AbstractRequest
{
    /**
     * @var \Kerox\Messenger\Model\ThreadControl
     */
    protected $threadControl;

    /**
     * TagRequest constructor.
     *
     * @param string                               $pageToken
     * @param \Kerox\Messenger\Model\ThreadControl $threadControl
     */
    public function __construct(string $pageToken, ThreadControl $threadControl)
    {
        parent::__construct($pageToken);

        $this->threadControl = $threadControl;
    }

    /**
     * @return array
     */
    protected function buildHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @return \Kerox\Messenger\Model\ThreadControl
     */
    protected function buildBody(): ThreadControl
    {
        return $this->threadControl;
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        return parent::buildQuery();
    }
}
