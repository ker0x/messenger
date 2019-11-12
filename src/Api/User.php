<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Exception\InvalidKeyException;
use Kerox\Messenger\Request\UserRequest;
use Kerox\Messenger\Response\UserResponse;
use Kerox\Messenger\UserInterface;

class User extends AbstractApi implements UserInterface
{
    /**
     * @throws \Kerox\Messenger\Exception\MessengerException
     */
    public function profile(string $userId, array $fields = []): UserResponse
    {
        $allowedFields = $this->getAllowedFields();
        $fields = empty($fields) ? $allowedFields : $fields;

        if ($fields !== $allowedFields) {
            foreach ($fields as $field) {
                if (!\in_array($field, $allowedFields, true)) {
                    throw new InvalidKeyException(sprintf('%s is not a valid value. fields must only contain "%s".', $field, implode(', ', $allowedFields)));
                }
            }
        }

        $request = new UserRequest($this->pageToken, $fields);
        $response = $this->client->get($userId, $request->build());

        return new UserResponse($response);
    }

    private function getAllowedFields(): array
    {
        return [
            self::FIRST_NAME,
            self::LAST_NAME,
            self::PROFILE_PIC,
            self::LOCALE,
            self::TIMEZONE,
            self::GENDER,
        ];
    }
}
