<?php

declare(strict_types=1);

namespace Kerox\Messenger\Helper;

use InvalidArgumentException;
use Kerox\Messenger\Model\Common\Button\AbstractButton;
use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\SendInterface;

trait ValidatorTrait
{
    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidColor(string $value): void
    {
        if (!preg_match('/^#[A-Fa-f0-9]{6}$/', $value)) {
            throw new InvalidArgumentException('The color must be expressed in #rrggbb format.');
        }
    }

    /**
     * @param string $value
     * @param int    $length
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidString(string $value, int $length = 20): void
    {
        if (mb_strlen($value) > $length) {
            throw new InvalidArgumentException("String should not exceed {$length} characters.");
        }
    }

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidUrl(string $value): void
    {
        if (!preg_match(
            '/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/=]*)$/',
            $value
        )) {
            throw new InvalidArgumentException("{$value} is not a valid url.");
        }
    }

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidLocale(string $value): void
    {
        if (!preg_match('/^[a-z]{2}_[A-Z]{2}$/', $value)) {
            throw new InvalidArgumentException(
                "{$value} is not valid. Locale must be in ISO-639-1 and ISO-3166-1 format like fr_FR."
            );
        }
    }

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidCountry(string $value): void
    {
        if (!preg_match('/^[A-Z]{2}$/', $value)) {
            throw new InvalidArgumentException(
                "{$value} is not valid. Country must be in ISO 3166 Alpha-2 format like FR."
            );
        }
    }

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidDateTime(string $value): void
    {
        if (!preg_match('/^(\d{4})-(0[1-9]|1[0-2])-([12]\d|0[1-9]|3[01])T(0\d|1\d|2[0-3]):([0-5]\d)$/', $value)) {
            throw new InvalidArgumentException(
                "{$value} is not valid. DateTime must be in ISO-8601 AAAA-MM-JJThh:mm format"
            );
        }
    }

    /**
     * @param array $array
     * @param int   $maxSize
     * @param int   $minSize
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidArray(array $array, int $maxSize, ?int $minSize = null): void
    {
        $countArray = \count($array);
        if ($minSize !== null && $countArray < $minSize) {
            throw new InvalidArgumentException("The minimum number of items for this array is {$minSize}.");
        }
        if ($countArray > $maxSize) {
            throw new InvalidArgumentException("The maximum number of items for this array is {$maxSize}.");
        }
    }

    /**
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidCurrency(string $value): void
    {
        $allowedCurrency = $this->getAllowedCurrency();

        $regex = '/^' . implode('|', $allowedCurrency) . '$/';
        if (!preg_match($regex, $value)) {
            throw new InvalidArgumentException(
                "{$value} is not a valid currency. Currency must be in ISO-4217-3 format."
            );
        }
    }

    /**
     * @param string $filename
     * @param array  $allowedExtension
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidExtension(string $filename, array $allowedExtension): void
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (empty($ext) || !\in_array($ext, $allowedExtension, true)) {
            throw new InvalidArgumentException(
                "{$filename} doesn't have a valid extension. Allowed extensions are " . implode(', ', $allowedExtension)
            );
        }
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     * @param array                                                 $allowedButtonsType
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidButtons(array $buttons, array $allowedButtonsType): void
    {
        /** @var \Kerox\Messenger\Model\Common\Button\AbstractButton $button */
        foreach ($buttons as $button) {
            if (!$button instanceof AbstractButton) {
                throw new \InvalidArgumentException('Array can only contain instance of AbstractButton.');
            }

            if (!\in_array($button->getType(), $allowedButtonsType, true)) {
                throw new \InvalidArgumentException(
                    'Buttons can only be an instance of ' . implode(', ', $allowedButtonsType)
                );
            }
        }
    }

    /**
     * @param $message
     *
     * @throws \Exception
     *
     * @return \Kerox\Messenger\Model\Message
     */
    protected function isValidMessage($message): Message
    {
        if ($message instanceof Message) {
            return $message;
        }

        if (\is_string($message) || $message instanceof Attachment) {
            return Message::create($message);
        }

        throw new \InvalidArgumentException('$message must be a string or an instance of Message or Attachment');
    }

    /**
     * @param string $action
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidSenderAction(string $action): void
    {
        $allowedSenderAction = $this->getAllowedSenderAction();
        if (!\in_array($action, $allowedSenderAction, true)) {
            throw new \InvalidArgumentException('$action must be either ' . implode(', ', $allowedSenderAction));
        }
    }

    /**
     * @param string $notificationType
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidNotificationType(string $notificationType): void
    {
        $allowedNotificationType = $this->getAllowedNotificationType();
        if (!\in_array($notificationType, $allowedNotificationType, true)) {
            throw new \InvalidArgumentException(
                '$notificationType must be either ' . implode(', ', $allowedNotificationType)
            );
        }
    }

    /**
     * @param string $tag
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidTag(string $tag): void
    {
        $allowedTag = $this->getAllowedTag();
        if (!\in_array($tag, $allowedTag, true)) {
            throw new \InvalidArgumentException('$tag must be either ' . implode(', ', $allowedTag));
        }
    }

    /**
     * @return array
     */
    public function getAllowedSenderAction(): array
    {
        return [
            SendInterface::SENDER_ACTION_TYPING_ON,
            SendInterface::SENDER_ACTION_TYPING_OFF,
            SendInterface::SENDER_ACTION_MARK_SEEN,
        ];
    }

    /**
     * @return array
     */
    public function getAllowedNotificationType(): array
    {
        return [
            SendInterface::NOTIFICATION_TYPE_REGULAR,
            SendInterface::NOTIFICATION_TYPE_SILENT_PUSH,
            SendInterface::NOTIFICATION_TYPE_NO_PUSH,
        ];
    }

    /**
     * @return array
     */
    public function getAllowedTag(): array
    {
        return [
            SendInterface::TAG_COMMUNITY_ALERT,
            SendInterface::TAG_CONFIRMED_EVENT_REMINDER,
            SendInterface::TAG_NON_PROMOTIONAL_SUBSCRIPTION,
            SendInterface::TAG_PAIRING_UPDATE,
            SendInterface::TAG_APPLICATION_UPDATE,
            SendInterface::TAG_ACCOUNT_UPDATE,
            SendInterface::TAG_PAYMENT_UPDATE,
            SendInterface::TAG_PERSONAL_FINANCE_UPDATE,
            SendInterface::TAG_SHIPPING_UPDATE,
            SendInterface::TAG_RESERVATION_UPDATE,
            SendInterface::TAG_ISSUE_RESOLUTION,
            SendInterface::TAG_APPOINTMENT_UPDATE,
            SendInterface::TAG_GAME_EVENT,
            SendInterface::TAG_TRANSPORTATION_UPDATE,
            SendInterface::TAG_FEATURE_FUNCTIONALITY_UPDATE,
            SendInterface::TAG_TICKET_UPDATE,
        ];
    }

    /**
     * @return array
     */
    public function getAllowedCurrency(): array
    {
        return [
            'SGD',
            'RON',
            'EUR',
            'TRY',
            'SEK',
            'ZAR',
            'HKD',
            'CHF',
            'NIO',
            'JPY',
            'ISK',
            'TWD',
            'NZD',
            'CZK',
            'AUD',
            'THB',
            'BOB',
            'BRL',
            'MXN',
            'USD',
            'ILS',
            'HNL',
            'MOP',
            'COP',
            'UYU',
            'CRC',
            'DKK',
            'QAR',
            'PYG',
            'CAD',
            'INR',
            'KRW',
            'GTQ',
            'AED',
            'VEF',
            'SAR',
            'NOK',
            'CNY',
            'ARS',
            'PLN',
            'GBP',
            'PEN',
            'PHP',
            'VND',
            'RUB',
            'HUF',
            'MYR',
            'CLP',
            'IDR',
        ];
    }
}
