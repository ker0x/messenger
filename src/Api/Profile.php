<?php

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Model\ProfileSettings;
use Kerox\Messenger\ProfileInterface;
use Kerox\Messenger\Request\ProfileRequest;
use Kerox\Messenger\Response\ProfileResponse;

class Profile extends AbstractApi implements ProfileInterface
{
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
    private function isValidFields(array $fields)
    {
        $allowedFields = $this->getAllowedFields();
        foreach ($fields as $field) {
            if (!in_array($field, $allowedFields, true)) {
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
