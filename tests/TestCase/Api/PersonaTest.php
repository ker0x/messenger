<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Persona;
use Kerox\Messenger\Model\Data;
use Kerox\Messenger\Model\PersonaSettings;
use PHPUnit\Framework\TestCase;

class PersonaTest extends TestCase
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

        self::assertSame('<PERSONA_ID>', $response->getId());
        self::assertNull($response->getName());
        self::assertNull($response->getProfilePictureUrl());
        self::assertEmpty($response->getData());
        self::assertFalse($response->isSuccess());
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

        self::assertSame('<PERSONA_ID>', $response->getId());
        self::assertSame('John Mathew', $response->getName());
        self::assertSame('https://facebook.com/john_image.jpg', $response->getProfilePictureUrl());
        self::assertEmpty($response->getData());
        self::assertFalse($response->isSuccess());
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

        self::assertNull($response->getId());
        self::assertNull($response->getName());
        self::assertNull($response->getProfilePictureUrl());
        self::assertFalse($response->isSuccess());
        self::assertEquals($this->getData(), $response->getData());
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

        self::assertNull($response->getId());
        self::assertNull($response->getName());
        self::assertNull($response->getProfilePictureUrl());
        self::assertEmpty($response->getData());
        self::assertTrue($response->isSuccess());
    }

    private function getData(): array
    {
        $datas = json_decode(file_get_contents(__DIR__ . '/../../Mocks/Response/Persona/get_all.json'), true, 512, JSON_THROW_ON_ERROR);

        $tags = [];
        foreach ($datas['data'] as $data) {
            $tags[] = Data::create($data);
        }

        return $tags;
    }
}
