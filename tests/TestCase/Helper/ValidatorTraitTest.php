<?php
namespace Kerox\Messenger\Test\TestCase;

use Kerox\Messenger\Helper\ValidatorTrait;

class TestValidatorTrait extends AbstractTestCase
{

    use ValidatorTrait;

    public function testInvalidColor()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The color must be expressed in #rrggbb format.');
        $this->isValidColor('#000');
    }

    public function testInvalidString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('String should not exceed 20 characters.');
        $this->isValidString('abcdefghijklmnopqrstuvwxyz');
    }

    public function testInvalidUrl()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('./img/image.png is not a valid url.');
        $this->isValidUrl('./img/image.png');
    }

    public function testInvalidLocale()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('FR_fr is not valid. Locale must be in ISO-639-1 and ISO-3166-1 format like fr_FR.');
        $this->isValidLocale('FR_fr');
    }

    public function testInvalidCountry()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('us is not valid. Country must be in ISO 3166 Alpha-2 format like FR.');
        $this->isValidCountry('us');
    }

    public function testInvalidDateTime()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('20-11-2016T15:00 is not valid. DateTime must be in ISO-8601 AAAA-MM-JJThh:mm format');
        $this->isValidDateTime('20-11-2016T15:00');
    }

    public function testInvalidArrayForMax()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The maximum number of items for this array is 2.');
        $this->isValidArray(['value-1', 'value-2', 'value-3'], 2);
    }

    public function testInvalidArrayForMin()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The minimum number of items for this array is 3.');
        $this->isValidArray(['value-1', 'value-2'], 4, 3);
    }

    public function testInvalidCurrency()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('€ is not a valid currency. Currency must be in ISO-4217-3 format.');
        $this->isValidCurrency('€');
    }

    public function testInvalidExtension()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('http://example.com/img/image.bmp doesn\'t have a valid extension. Allowed extensions are jpg, png, gif');
        $this->isValidExtension('http://example.com/img/image.bmp', ['jpg', 'png', 'gif']);
    }
}