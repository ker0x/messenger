<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Persona;
use Kerox\Messenger\Model\Data;
use Kerox\Messenger\Model\PersonaSettings;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PersonaTest extends AbstractTestCase
{
    public function testAdd(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Persona/add.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $personaApi = new Persona('abcd1234', $client);

        $response = $personaApi->add(PersonaSettings::create('John Mathew', 'https://facebook.com/john_image.jpg'));

        $this->assertSame('<PERSONA_ID>', $response->getId());
        $this->assertNull($response->getName());
        $this->assertNull($response->getProfilePictureUrl());
        $this->assertEmpty($response->getData());
        $this->assertFalse($response->isSuccess());
    }

    public function testGet(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Persona/get.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $personaApi = new Persona('abcd1234', $client);

        $response = $personaApi->get('<PERSONA_ID>');

        $this->assertSame('<PERSONA_ID>', $response->getId());
        $this->assertSame('John Mathew', $response->getName());
        $this->assertSame('https://facebook.com/john_image.jpg', $response->getProfilePictureUrl());
        $this->assertEmpty($response->getData());
        $this->assertFalse($response->isSuccess());
    }

    public function testGetAll(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Persona/get_all.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $personaApi = new Persona('abcd1234', $client);

        $response = $personaApi->getAll();

        $this->assertNull($response->getId());
        $this->assertNull($response->getName());
        $this->assertNull($response->getProfilePictureUrl());
        $this->assertFalse($response->isSuccess());
        $this->assertEquals($this->getData(), $response->getData());
    }

    public function testDelete(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Persona/delete.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $personaApi = new Persona('abcd1234', $client);

        $response = $personaApi->delete('<PERSONA_ID>');

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
        $datas = json_decode(file_get_contents(__DIR__ . '/../../Mocks/Response/Persona/get_all.json'), true);

        $tags = [];
        foreach ($datas['data'] as $data) {
            $tags[] = Data::create($data);
        }

        return $tags;
    }
}
