<?php

namespace Kerox\Messenger\Test\TestCase\Model\Common;

use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class AddressTest extends AbstractTestCase
{
    public function testAddress()
    {
        $expectedJson = file_get_contents(__DIR__ . '/../../../Mocks/Address/address.json');

        $address = Address::create('1 Hacker Way', 'MENLO PARK', '94025', 'CA', 'US');
        $address
            ->setName('Romain Monteil')
            ->setAdditionalStreet('3rd floor')
            ->setId(1234);

        $this->assertJsonStringEqualsJsonString($expectedJson, json_encode($address));
    }
}
