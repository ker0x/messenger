<?php

declare(strict_types=1);

namespace Kerox\Messenger\Api;

use Kerox\Messenger\Request\UserRequest;
use Kerox\Messenger\Response\UserResponse;
use Kerox\Messenger\UserInterface;

class User extends AbstractApi implements UserInterface
{
    /**
     * @param string     $userId
     * @param array|null $fields
     *
     * @throws \InvalidArgumentException
     *
     * @return \Kerox\Messenger\Response\UserResponse
     */
    public function profile(string $userId, array $fields = []): UserResponse
    {
        $allowedFields = $this->getAllowedFields();
        $fields = empty($fields) ? $allowedFields : $fields;

        if ($fields !== $allowedFields) {
            foreach ($fields as $field) {
                if (!\in_array($field, $allowedFields, true)) {
                    throw new \InvalidArgumentException(
                        $field . ' is not a valid value. $fields must only contain ' . implode(', ', $allowedFields)
                    );
                }
            }
        }

        $request = new UserRequest($this->pageToken, $fields);
        $response = $this->client->get($userId, $request->build());

        return new UserResponse($response);
    }

    /**
     * @return array
     */
    private function getAllowedFields(): array
    {
        return [
            self::FIRST_NAME,
            self::LAST_NAME,
            self::PROFILE_PIC,
            self::LOCALE,
            self::TIMEZONE,
            self::GENDER,
            self::IS_PAYMENT_ENABLED,
        ];
    }
}
