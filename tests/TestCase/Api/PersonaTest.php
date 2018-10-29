<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Api;

use Kerox\Messenger\Api\Persona;
use Kerox\Messenger\Model\Data;
use Kerox\Messenger\Model\PersonaSettings;
use Kerox\Messenger\Test\TestCase\ResourceTestCase;

/**
 * Class PersonaTest
 *
 * @property Persona $resource
 */
class PersonaTest extends ResourceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->resource = new Persona($this->client);
    }

    public function testAdd(): void
    {
        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Persona/add.json');
        $this->mockHandler->append($mockedResponse);

        $response = $this->resource->add(PersonaSettings::create('John Mathew', 'https://facebook.com/john_image.jpg'));

        $this->assertSame('<PERSONA_ID>', $response->getId());
        $this->assertNull($response->getName());
        $this->assertNull($response->getProfilePictureUrl());
        $this->assertEmpty($response->getData());
        $this->assertFalse($response->isSuccess());
    }

    public function testGet(): void
    {
        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Persona/get.json');
        $this->mockHandler->append($mockedResponse);

        $response = $this->resource->get('<PERSONA_ID>');

        $this->assertSame('<PERSONA_ID>', $response->getId());
        $this->assertSame('John Mathew', $response->getName());
        $this->assertSame('https://facebook.com/john_image.jpg', $response->getProfilePictureUrl());
        $this->assertEmpty($response->getData());
        $this->assertFalse($response->isSuccess());
    }

    public function testGetAll(): void
    {
        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Persona/get_all.json');
        $this->mockHandler->append($mockedResponse);

        $response = $this->resource->getAll();

        $this->assertNull($response->getId());
        $this->assertNull($response->getName());
        $this->assertNull($response->getProfilePictureUrl());
        $this->assertFalse($response->isSuccess());
        $this->assertEquals($this->getData(), $response->getData());
    }

    public function testDelete(): void
    {
        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Persona/delete.json');
        $this->mockHandler->append($mockedResponse);

        $response = $this->resource->delete('<PERSONA_ID>');

        $this->assertNull($response->getId());
        $this->assertNull($response->getName());
        $this->assertNull($response->getProfilePictureUrl());
        $this->assertEmpty($response->getData());
        $this->assertTrue($response->isSuccess());
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        $dataList = json_decode(file_get_contents(__DIR__ . '/../../Mocks/Response/Persona/get_all.json'), true);

        return array_map(function (array $row) {
            return Data::create($row);
        }, $dataList['data']);
    }
}
