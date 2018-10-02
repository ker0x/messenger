<?php

namespace Kerox\Messenger\Test\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Persona;
use Kerox\Messenger\Response\PersonaDataResponse;
use Kerox\Messenger\Response\PersonaResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class PersonaTest extends AbstractTestCase
{
    public function testCreate()
    {
        $data = ['id' => $this->randomIntegerString()];
        $response = new Response(200, [], json_encode($data));

        /** @var Client|MockObject $client */
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $service = new Persona('test', $client);
        $result = $service->create('John Doe', 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce');

        $this->assertInstanceOf(PersonaResponse::class, $result);
        $this->assertEquals($data['id'], $result->getId());
    }

    public function testGetOne()
    {
        $personaId = $this->randomIntegerString();
        $data = [
            'id' => $personaId,
            'name' => 'John Doe',
            'profile_picture_url' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce',
        ];
        $response = new Response(200, [], json_encode($data));

        /** @var Client|MockObject $client */
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $service = new Persona('test', $client);
        $result = $service->getOne($personaId);

        $this->assertInstanceOf(PersonaResponse::class, $result);
        $this->assertInstanceOf(\Kerox\Messenger\Model\Persona::class, $result->getPersona());

        $this->assertEquals($data['id'], $result->getPersona()->getId());
        $this->assertEquals($data['name'], $result->getPersona()->getName());
        $this->assertEquals($data['profile_picture_url'], $result->getPersona()->getProfilePictureUrl());
    }

    public function testGetAll()
    {
        $data = [
            'data' => [
                [
                    'id' => $this->randomIntegerString(),
                    'name' => 'John Doe',
                    'profile_picture_url' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce',
                ],
                [
                    'id' => $this->randomIntegerString(),
                    'name' => 'Sam Smith',
                    'profile_picture_url' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/v/t1.0-1/p200x200/13055603_10105219398495383_8237637584159975445_n.jpg?oh=1d241d4b6d4dac50eaf9bb73288ea192&oe=57AF5C03&__gda__=1470213755_ab17c8c8e3a0a447fed3f272fa2179ce',
                ],
            ],
            'paging' => [
                'cursors' => [
                    'before' => 'QVFIUlMtR2ZATQlRtVUZALUlloV1',
                    'after' => 'QVFIUkpnMGx0aTNvUjJNVmJUT0Yw',
                ],
            ],
        ];
        $response = new Response(200, [], json_encode($data));

        /** @var Client|MockObject $client */
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $service = new Persona('test', $client);
        $result = $service->getAll();

        $this->assertInstanceOf(PersonaDataResponse::class, $result);
        $this->assertCount(2, $result->getData());
    }

    public function testDelete()
    {
        $personaId = $this->randomIntegerString();
        $data = ['success' => true];
        $response = new Response(200, [], json_encode($data));

        /** @var Client|MockObject $client */
        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $service = new Persona('test', $client);
        $result = $service->delete($personaId);

        $this->assertInstanceOf(PersonaResponse::class, $result);
        $this->assertTrue($result->isSuccess());
    }
}
