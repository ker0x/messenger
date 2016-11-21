<?php
namespace Kerox\Messenger\Model\ThreadSettings;

use Kerox\Messenger\Model\ThreadSettings;

class AccountLinking extends ThreadSettings
{

    /**
     * @var string
     */
    protected $accountLinkingUrl;

    /**
     * AccountLinking constructor.
     *
     * @param string $accountLinkingUrl
     */
    public function __construct(string $accountLinkingUrl)
    {
        parent::__construct(ThreadSettings::TYPE_ACCOUNT_LINKING);

        $this->isValidUrl($accountLinkingUrl);

        $this->accountLinkingUrl = $accountLinkingUrl;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'account_linking_url' => $this->accountLinkingUrl,
        ];

        return $json;
    }
}
