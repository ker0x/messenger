<?php
namespace Kerox\Messenger\Api;

use GuzzleHttp\Client;
use Kerox\Messenger\Request\UserRequest;
use Kerox\Messenger\Response\UserResponse;
use Kerox\Messenger\UserInterface;

class User extends AbstractApi implements UserInterface
{

    /**
     * Send constructor.
     *
     * @param string $pageToken
     */
    public function __construct(string $pageToken)
    {
        parent::__construct($pageToken);
    }

    /**
     * @param string $userId
     * @param array|null $fields
     * @return \Kerox\Messenger\Response\UserResponse
     */
    public function getProfile(string $userId, array $fields = null): UserResponse
    {
        $allowedFields = $this->getAllowedFields();
        if ($fields !== null) {
            foreach ($fields as $field) {
                if (!in_array($field, $allowedFields)) {
                    throw new \InvalidArgumentException($field . ' is not a valid value. $userProfileFields must only contain ' . implode(', ', $allowedFields));
                }
            }
        } else {
            $fields = $allowedFields;
        }

        $request = new UserRequest($this->pageToken, $fields);
        $response = $this->client->get(sprintf('/%s', $userId), $request->build());

        return new UserResponse($response);
    }

    /**
     * @return array
     */
    private function getAllowedFields(): array
    {
        return [
            UserInterface::FIRST_NAME,
            UserInterface::LAST_NAME,
            UserInterface::PROFILE_PIC,
            UserInterface::LOCALE,
            UserInterface::TIMEZONE,
            UserInterface::GENDER,
            UserInterface::IS_PAYMENT_ENABLED,
        ];
    }
}
