<?php
namespace Kerox\Messenger\Helper;

use InvalidArgumentException;

trait ValidatorTrait
{

    /**
     * @param string $value
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isValidColor(string $value)
    {
        if (!preg_match('/^#[A-Fa-f0-9]{6}$/', $value)) {
            throw new InvalidArgumentException("The color must be expressed in #rrggbb format.");
        }
    }

    /**
     * @param string $value
     * @param int $length
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isValidString(string $value, int $length = 20)
    {
        if (mb_strlen($value) > $length) {
            throw new InvalidArgumentException("String should not exceed {$length} characters.");
        }
    }

    /**
     * @param string $value
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isValidUrl(string $value)
    {
        if (!preg_match('/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/=]*)$/', $value)) {
            throw new InvalidArgumentException("{$value} is not a valid url.");
        }
    }

    /**
     * @param string $value
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isValidLocale(string $value)
    {
        if (!preg_match('/^[a-z]{2}_[A-Z]{2}$/', $value)) {
            throw new InvalidArgumentException("{$value} is not valid. Locale must be in ISO-639-1 and ISO-3166-1 format like fr_FR.");
        }
    }

    /**
     * @param string $value
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isValidCountry(string $value)
    {
        if (!preg_match('/^[A-Z]{2}$/', $value)) {
            throw new InvalidArgumentException("{$value} is not valid. Country must be in ISO 3166 Alpha-2 format like FR.");
        }
    }

    /**
     * @param string $value
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isValidDateTime(string $value)
    {
        if (!preg_match('/^(\d{4})-(0[1-9]|1[0-2])-([12]\d|0[1-9]|3[01])T(0[0-9]|1\d|2[0-3]):([0-5]\d)$/', $value)) {
            throw new InvalidArgumentException("{$value} is not valid. DateTime must be in ISO-8601 AAAA-MM-JJThh:mm format");
        }
    }

    /**
     * @param array $array
     * @param int $maxSize
     * @param int $minSize
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isValidArray(array $array, int $maxSize, int $minSize = null)
    {
        $countArray = count($array);
        if ($minSize !== null && $countArray < $minSize) {
            throw new InvalidArgumentException("The minimum number of items for this array is {$minSize}.");
        }
        if ($countArray > $maxSize) {
            throw new InvalidArgumentException("The maximum number of items for this array is {$maxSize}.");
        }
    }

    /**
     * @param string $value
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isValidCurrency(string $value)
    {
        if (!preg_match('/^SGD|RON|EUR|TRY|SEK|ZAR|HKD|CHF|NIO|JPY|ISK|TWD|NZD|CZK|AUD|THB|BOB|BRL|MXN|USD|ILS|HNL|MOP|COP|UYU|CRC|DKK|QAR|PYG|CAD|INR|KRW|GTQ|AED|VEF|SAR|NOK|CNY|ARS|PLN|GBP|PEN|PHP|VND|RUB|HUF|MYR|CLP|IDR$/', $value)) {
            throw new InvalidArgumentException("{$value} is not a valid currency. Currency must be in ISO-4217-3 format.");
        }
    }

    /**
     * @param string $filename
     * @param array $allowedExtension
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function isValidExtension(string $filename, array $allowedExtension)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (empty($ext) || !in_array($ext, $allowedExtension)) {
            throw new InvalidArgumentException("{$filename} doesn't have a valid extension. Allowed extensions are " . implode(', ', $allowedExtension));
        }
    }
}
