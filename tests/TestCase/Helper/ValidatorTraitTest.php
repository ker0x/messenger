<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Helper;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Helper\ValidatorTrait;
use PHPUnit\Framework\TestCase;

class ValidatorTraitTest extends TestCase
{
    use ValidatorTrait;

    public function testInvalidColor(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('The color must be expressed in #rrggbb format.');
        $this->isValidColor('#000');
    }

    public function testInvalidString(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('String should not exceed 20 characters.');
        $this->isValidString('abcdefghijklmnopqrstuvwxyz');
    }

    public function testInvalidUrl(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('"./img/image.png" is not a valid url.');
        $this->isValidUrl('./img/image.png');
    }

    public function testInvalidLocale(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('"FR_fr" is not valid. Locale must be in ISO-639-1 and ISO-3166-1 format like fr_FR.');
        $this->isValidLocale('FR_fr');
    }

    public function testInvalidCountry(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('"us" is not valid. Country must be in ISO 3166 Alpha-2 format like FR.');
        $this->isValidCountry('us');
    }

    public function testInvalidDateTime(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('"20-11-2016T15:00" is not valid. DateTime must be in ISO-8601 AAAA-MM-JJThh:mm format.');
        $this->isValidDateTime('20-11-2016T15:00');
    }

    public function testInvalidArrayForMax(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('The maximum number of items for this array is 2.');
        $this->isValidArray(['value-1', 'value-2', 'value-3'], 2);
    }

    public function testInvalidArrayForMin(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('The minimum number of items for this array is 3.');
        $this->isValidArray(['value-1', 'value-2'], 4, 3);
    }

    public function testInvalidCurrency(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('"€" is not a valid currency. Currency must be in ISO-4217-3 format.');
        $this->isValidCurrency('€');
    }

    public function testInvalidExtension(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('"http://example.com/img/image.bmp" does not have a valid extension. Allowed extensions are "jpg, png, gif".');
        $this->isValidExtension('http://example.com/img/image.bmp', ['jpg', 'png', 'gif']);
    }
}
