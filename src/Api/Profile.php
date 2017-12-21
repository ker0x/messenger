<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use GuzzleHttp\ClientInterface;
use Kerox\Messenger\Model\ProfileSettings;
use Kerox\Messenger\ProfileInterface;
use Kerox\Messenger\Request\ProfileRequest;
use Kerox\Messenger\Response\ProfileResponse;

class Profile extends AbstractApi implements ProfileInterface
{
    /**
     * @var null|\Kerox\Messenger\Api\Profile
     */
    private static $_instance;

    /**
     * @param string                      $pageToken
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return \Kerox\Messenger\Api\Profile
     */
    public static function getInstance(string $pageToken, ClientInterface $client): self
    {
        if (self::$_instance === null) {
            self::$_instance = new self($pageToken, $client);
        }

        return self::$_instance;
    }

    /**
     * @param \Kerox\Messenger\Model\ProfileSettings $profileSettings
     *
     * @return \Kerox\Messenger\Response\ProfileResponse
     */
    public function add(ProfileSettings $profileSettings): ProfileResponse
    {
        $request = new ProfileRequest($this->pageToken, $profileSettings);
        $response = $this->client->post('me/messenger_profile', $request->build());

        return new ProfileResponse($response);
    }

    /**
     * @param array $profileSettings
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Response\ProfileResponse
     */
    public function get(array $profileSettings): ProfileResponse
    {
        $this->isValidFields($profileSettings);

        $profileSettings = implode(',', $profileSettings);

        $request = new ProfileRequest($this->pageToken, $profileSettings);
        $response = $this->client->get('me/messenger_profile', $request->build());

        return new ProfileResponse($response);
    }

    /**
     * @param array $profileSettings
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Response\ProfileResponse
     */
    public function delete(array $profileSettings): ProfileResponse
    {
        $this->isValidFields($profileSettings);

        $request = new ProfileRequest($this->pageToken, $profileSettings);
        $response = $this->client->delete('me/messenger_profile', $request->build());

        return new ProfileResponse($response);
    }

    /**
     * @param array $fields
     *
     * @throws \InvalidArgumentException
     */
    private function isValidFields(array $fields): void
    {
        $allowedFields = $this->getAllowedFields();
        foreach ($fields as $field) {
            if (!\in_array($field, $allowedFields, true)) {
                throw new \InvalidArgumentException($field . ' is not a valid value. $fields must only contain ' . implode(', ', $allowedFields));
            }
        }
    }

    /**
     * @return array
     */
    private function getAllowedFields(): array
    {
        return [
            ProfileInterface::PERSISTENT_MENU,
            ProfileInterface::GET_STARTED,
            ProfileInterface::GREETING,
            ProfileInterface::DOMAIN_WHITELISTING,
            ProfileInterface::ACCOUNT_LINKING_URL,
            ProfileInterface::PAYMENT_SETTINGS,
            ProfileInterface::TARGET_AUDIENCE,
        ];
    }
}
