<?php
namespace Kerox\Messenger\Model\ThreadSettings;

use Kerox\Messenger\Model\ThreadSettings;

/**
 * @deprecated since 1.2.0 and will be remove in 1.3.0.
 * @see \Kerox\Messenger\Model\ProfileSettings::addWhitelistedDomains()
 */
class DomainWhitelist extends ThreadSettings implements ActionTypeInterface
{

    /**
     * @var array
     */
    protected $whitelistedDomains;

    /**
     * @var string
     */
    protected $actionType;

    /**
     * DomainWhitelist constructor.
     *
     * @param array $whitelistedDomains
     * @param string $actionType
     */
    public function __construct(array $whitelistedDomains, $actionType = ActionTypeInterface::ADD)
    {
        parent::__construct(ThreadSettings::TYPE_DOMAIN_WHITELISTING);

        $this->isValidArray($whitelistedDomains, 10);
        $this->isValidDomains($whitelistedDomains);
        $this->isValidActionType($actionType);

        $this->whitelistedDomains = $whitelistedDomains;
        $this->actionType = $actionType;
    }

    /**
     * @param array $domains
     */
    private function isValidDomains(array $domains)
    {
        foreach ($domains as $domain) {
            $this->isValidUrl($domain);
        }
    }

    /**
     * @param $actionType
     * @throws \InvalidArgumentException
     */
    private function isValidActionType(string $actionType)
    {
        $allowedActionType = $this->getAllowedActionType();
        if (!in_array($actionType, $allowedActionType)) {
            throw new \InvalidArgumentException('$actionType must be either ' . implode(', ', $allowedActionType));
        }
    }

    /**
     * @return array
     */
    private function getAllowedActionType(): array
    {
        return [
            ActionTypeInterface::ADD,
            ActionTypeInterface::REMOVE,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = parent::jsonSerialize();
        $json += [
            'whitelisted_domains' => $this->whitelistedDomains,
            'domain_action_type' => $this->actionType,
        ];

        return $json;
    }
}
