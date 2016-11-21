<?php
namespace Kerox\Messenger\Request;

use Kerox\Messenger\Model\ThreadSettings;

class ThreadRequest extends AbstractRequest
{

    /**
     * @var \Kerox\Messenger\Model\ThreadSettings
     */
    protected $threadSettings;

    /**
     * ThreadRequest constructor.
     *
     * @param string $pageToken
     * @param \Kerox\Messenger\Model\ThreadSettings $threadSettings
     */
    public function __construct(string $pageToken, ThreadSettings $threadSettings)
    {
        parent::__construct($pageToken);

        $this->threadSettings = $threadSettings;
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
     * @return ThreadSettings
     */
    protected function buildBody(): ThreadSettings
    {
        return $this->threadSettings;
    }

    /**
     * @return array
     */
    protected function buildQuery(): array
    {
        return parent::buildQuery();
    }
}