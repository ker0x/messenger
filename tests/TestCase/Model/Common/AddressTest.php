<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Common;

use Kerox\Messenger\Model\Common\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testAddress(): void
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Address/address.json');

        $address = Address::create('1 Hacker Way', 'MENLO PARK', '94025', 'CA', 'US');
        $address
            ->setName('Romain Monteil')
            ->setAdditionalStreet('3rd floor')
            ->setId(1234);

        self::assertJsonStringEqualsJsonString($expectedJson, json_encode($address, JSON_THROW_ON_ERROR));
    }
}
