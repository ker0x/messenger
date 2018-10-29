<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Model\PersonaSettings;
use Kerox\Messenger\Request\PersonaRequest;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;
use Psr\Http\Message\StreamInterface;

class PersonaRequestTest extends AbstractTestCase
{
    public function testBuildPostWithPersona()
    {
        $persona = PersonaSettings::create('John Mathew', 'https://facebook.com/john_image.jpg');
        $request = new PersonaRequest('me/personas', $persona);
        $origin = $request->build('post');

        $expected = json_encode([
            'name' => 'John Mathew',
            'profile_picture_url' => 'https://facebook.com/john_image.jpg',
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/personas', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }

    public function testBuildGetRequest()
    {
        $personaId = '1712444532121303';
        $request = new PersonaRequest($personaId);
        $origin = $request->build('get');

        $this->assertSame('GET', $origin->getMethod());
        $this->assertSame($personaId, $origin->getUri()->getPath());
    }

    public function testBuildDeleteRequest()
    {
        $personaId = '1712444532121303';
        $request = new PersonaRequest($personaId);
        $origin = $request->build('delete');

        $this->assertSame('DELETE', $origin->getMethod());
        $this->assertSame($personaId, $origin->getUri()->getPath());
    }
}
