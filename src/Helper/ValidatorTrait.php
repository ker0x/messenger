<?php

declare(strict_types=1);

namespace Kerox\Messenger\Helper;

use Kerox\Messenger\Exception\InvalidArrayException;
use Kerox\Messenger\Exception\InvalidClassException;
use Kerox\Messenger\Exception\InvalidColorException;
use Kerox\Messenger\Exception\InvalidCountryException;
use Kerox\Messenger\Exception\InvalidCurrencyException;
use Kerox\Messenger\Exception\InvalidDateTimeException;
use Kerox\Messenger\Exception\InvalidExtensionException;
use Kerox\Messenger\Exception\InvalidKeyException;
use Kerox\Messenger\Exception\InvalidLocaleException;
use Kerox\Messenger\Exception\InvalidStringException;
use Kerox\Messenger\Exception\InvalidTypeException;
use Kerox\Messenger\Exception\InvalidUrlException;
use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Common\Button\AbstractButton;
use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Model\Message\Attachment;
use Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate;
use Kerox\Messenger\SendInterface;

trait ValidatorTrait
{
    /**
     * @throws \Kerox\Messenger\Exception\InvalidColorException
     */
    protected function isValidColor(string $value): void
    {
        if (!preg_match('/^#[A-Fa-f0-9]{6}$/', $value)) {
            throw new InvalidColorException('The color must be expressed in #rrggbb format.');
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidStringException
     */
    protected function isValidString(string $value, int $length = 20): void
    {
        if (mb_strlen($value) > $length) {
            throw new InvalidStringException(sprintf('String should not exceed %s characters.', $length));
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidUrlException
     */
    protected function isValidUrl(string $value): void
    {
        if (!preg_match(
            '/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/=]*)$/',
            $value
        )) {
            throw new InvalidUrlException(sprintf('"%s" is not a valid url.', $value));
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidLocaleException
     */
    protected function isValidLocale(string $value): void
    {
        if (!preg_match('/^[a-z]{2}_[A-Z]{2}$/', $value)) {
            throw new InvalidLocaleException(sprintf('"%s" is not valid. Locale must be in ISO-639-1 and ISO-3166-1 format like fr_FR.', $value));
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidCountryException
     */
    protected function isValidCountry(string $value): void
    {
        if (!preg_match('/^[A-Z]{2}$/', $value)) {
            throw new InvalidCountryException(sprintf('"%s" is not valid. Country must be in ISO 3166 Alpha-2 format like FR.', $value));
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidDateTimeException
     */
    protected function isValidDateTime(string $value): void
    {
        if (!preg_match('/^(\d{4})-(0[1-9]|1[0-2])-([12]\d|0[1-9]|3[01])T(0\d|1\d|2[0-3]):([0-5]\d)$/', $value)) {
            throw new InvalidDateTimeException(sprintf('"%s" is not valid. DateTime must be in ISO-8601 AAAA-MM-JJThh:mm format.', $value));
        }
    }

    /**
     * @param int $minSize
     *
     * @throws \Kerox\Messenger\Exception\InvalidArrayException
     */
    protected function isValidArray(array $array, int $maxSize, ?int $minSize = null): void
    {
        $countArray = \count($array);
        if ($minSize !== null && $countArray < $minSize) {
            throw new InvalidArrayException(sprintf('The minimum number of items for this array is %d.', $minSize));
        }
        if ($countArray > $maxSize) {
            throw new InvalidArrayException(sprintf('The maximum number of items for this array is %d.', $maxSize));
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidCurrencyException
     */
    protected function isValidCurrency(string $value): void
    {
        $allowedCurrency = $this->getAllowedCurrency();

        $regex = '/^' . implode('|', $allowedCurrency) . '$/';
        if (!preg_match($regex, $value)) {
            throw new InvalidCurrencyException(sprintf('"%s" is not a valid currency. Currency must be in ISO-4217-3 format.', $value));
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidExtensionException
     */
    protected function isValidExtension(string $filename, array $allowedExtension): void
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (empty($ext) || !\in_array($ext, $allowedExtension, true)) {
            throw new InvalidExtensionException(sprintf('"%s" does not have a valid extension. Allowed extensions are "%s".', $filename, implode(', ', $allowedExtension)));
        }
    }

    /**
     * @param \Kerox\Messenger\Model\Common\Button\AbstractButton[] $buttons
     *
     * @throws \Kerox\Messenger\Exception\InvalidClassException
     */
    protected function isValidButtons(array $buttons, array $allowedButtonsType): void
    {
        /** @var \Kerox\Messenger\Model\Common\Button\AbstractButton $button */
        foreach ($buttons as $button) {
            if (!$button instanceof AbstractButton) {
                throw new InvalidClassException(sprintf('Array can only contain instance of "%s".', AbstractButton::class));
            }

            if (!\in_array($button->getType(), $allowedButtonsType, true)) {
                throw new InvalidClassException(sprintf('Buttons can only be an instance of "%s".', implode(', ', $allowedButtonsType)));
            }
        }
    }

    /**
     * @param mixed $message
     *
     * @throws \Exception
     */
    protected function isValidMessage($message): Message
    {
        if ($message instanceof Message) {
            return $message;
        }

        if (\is_string($message) || $message instanceof Attachment) {
            return Message::create($message);
        }

        throw new MessengerException(sprintf('"message" must be a string or an instance of "%s" or "%s".', Message::class, Attachment::class));
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidKeyException
     */
    protected function isValidSenderAction(string $action): void
    {
        $allowedSenderAction = $this->getAllowedSenderAction();
        if (!\in_array($action, $allowedSenderAction, true)) {
            throw new InvalidKeyException(sprintf('"action" must be either "%s".', implode(', ', $allowedSenderAction)));
        }
    }

    /**
     * @throws \Kerox\Messenger\Exception\InvalidTypeException
     */
    protected function isValidNotificationType(string $notificationType): void
    {
        $allowedNotificationType = $this->getAllowedNotificationType();
        if (!\in_array($notificationType, $allowedNotificationType, true)) {
            throw new InvalidTypeException(sprintf('"notificationType" must be either "%s".', implode(', ', $allowedNotificationType)));
        }
    }

    /**
     * @param mixed $message
     *
     * @throws \Kerox\Messenger\Exception\InvalidClassException
     * @throws \Kerox\Messenger\Exception\InvalidKeyException
     */
    protected function isValidTag(string $tag, $message = null): void
    {
        $allowedTag = $this->getAllowedTag();
        $deprecatedTag = $this->getDeprecatedTags();
        if (!\in_array($tag, $allowedTag, true)) {
            throw new InvalidKeyException(sprintf('"tag" must be either "%s".', implode(', ', $allowedTag)));
        }

        if (\in_array($tag, $deprecatedTag, true)) {
            $message = sprintf('Tag "%s" is deprecated, use one of "%s" instead.',
                $tag,
                implode(',', [
                    SendInterface::TAG_CONFIRMED_EVENT_UPDATE,
                    SendInterface::TAG_POST_PURCHASE_UPDATE,
                    SendInterface::TAG_ACCOUNT_UPDATE,
                ])
            );
            @trigger_error($message, E_USER_DEPRECATED);
        }

        if ($tag === SendInterface::TAG_ISSUE_RESOLUTION && $message !== null && !$message instanceof GenericTemplate) {
            throw new InvalidClassException(sprintf('"message" must be an instance of "%s" if tag is set to "%s".', GenericTemplate::class, SendInterface::TAG_ISSUE_RESOLUTION));
        }
    }

    protected function getAllowedSenderAction(): array
    {
        return [
            SendInterface::SENDER_ACTION_TYPING_ON,
            SendInterface::SENDER_ACTION_TYPING_OFF,
            SendInterface::SENDER_ACTION_MARK_SEEN,
        ];
    }

    protected function getAllowedNotificationType(): array
    {
        return [
            SendInterface::NOTIFICATION_TYPE_REGULAR,
            SendInterface::NOTIFICATION_TYPE_SILENT_PUSH,
            SendInterface::NOTIFICATION_TYPE_NO_PUSH,
        ];
    }

    protected function getAllowedTag(): array
    {
        return [
            SendInterface::TAG_CONFIRMED_EVENT_UPDATE,
            SendInterface::TAG_POST_PURCHASE_UPDATE,
            SendInterface::TAG_ACCOUNT_UPDATE,
            //Tags supported until March 4th, 2020.
            SendInterface::TAG_BUSINESS_PRODUCTIVITY,
            SendInterface::TAG_COMMUNITY_ALERT,
            SendInterface::TAG_CONFIRMED_EVENT_REMINDER,
            SendInterface::TAG_NON_PROMOTIONAL_SUBSCRIPTION,
            SendInterface::TAG_PAIRING_UPDATE,
            SendInterface::TAG_APPLICATION_UPDATE,
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

    protected function getDeprecatedTags(): array
    {
        return [
            SendInterface::TAG_BUSINESS_PRODUCTIVITY,
            SendInterface::TAG_COMMUNITY_ALERT,
            SendInterface::TAG_CONFIRMED_EVENT_REMINDER,
            SendInterface::TAG_NON_PROMOTIONAL_SUBSCRIPTION,
            SendInterface::TAG_PAIRING_UPDATE,
            SendInterface::TAG_APPLICATION_UPDATE,
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

    protected function getAllowedCurrency(): array
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
