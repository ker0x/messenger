<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\Client;
use Kerox\Messenger\Model\ThreadSettings;
use Kerox\Messenger\Request\ThreadRequest;
use Kerox\Messenger\Response\ThreadResponse;

class Thread extends AbstractApi
{

    /**
     * ThreadSettings constructor.
     *
     * @param string $pageToken
     * @param \GuzzleHttp\Client $client
     */
    public function __construct($pageToken, Client $client)
    {
        parent::__construct($pageToken, $client);
    }

    /**
     * @param \Kerox\Messenger\Model\ThreadSettings $threadSettings
     * @return \Kerox\Messenger\Response\ThreadResponse
     */
    public function add(ThreadSettings $threadSettings): ThreadResponse
    {
        $request = new ThreadRequest($this->pageToken, $threadSettings);
        $response = $this->client->post('/me/thread_settings', $request->build());

        return new ThreadResponse($response);
    }

    /**
     * @param string $type
     * @param string $state
     * @return void
     */
    public function delete(string $type, string $state = null)
    {
        $this->isValidThreadSettingType($type);

        $threadSettings = new ThreadSettings($type, $state);

        $request = new ThreadRequest($this->pageToken, $threadSettings);
        $this->client->delete('/me/thread_settings', $request->build());
    }

    /**
     * @param string $threadSettingsType
     * @throws \InvalidArgumentException
     */
    private function isValidThreadSettingType(string $threadSettingsType)
    {
        $allowedThreadSettingsType = $this->getAllowedThreadSettingsType();
        if (!in_array($threadSettingsType, $allowedThreadSettingsType)) {
            throw new \InvalidArgumentException('$threadSettingsType must be either ' . implode(', '), $allowedThreadSettingsType);
        }
    }

    /**
     * @return array
     */
    private function getAllowedThreadSettingsType(): array
    {
        return [
            ThreadSettings::TYPE_GREETING,
            ThreadSettings::TYPE_CALL_TO_ACTIONS,
            ThreadSettings::TYPE_DOMAIN_WHITELISTING,
            ThreadSettings::TYPE_ACCOUNT_LINKING,
            ThreadSettings::TYPE_PAYMENT,
        ];
    }
}
