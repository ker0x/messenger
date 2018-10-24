<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Request\CodeRequest;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;
use Psr\Http\Message\StreamInterface;

class CodeRequestTest extends AbstractTestCase
{
    public function testBuildWithImageSizeAndCodeType()
    {
        $request = new CodeRequest('me/messenger_codes', 1200, 'standard');
        $origin = $request->build();

        $expected = json_encode([
            'type' => 'standard',
            'image_size' => 1200,
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/messenger_codes', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }

    public function testBuildWithAllParams()
    {
        $request = new CodeRequest('me/messenger_codes', 1000, 'standard', 'eA.2fL0-4fxK.jSpw@6ud6-=U7y=AMMiEvxK');
        $origin = $request->build();

        $expected = json_encode([
            'type' => 'standard',
            'image_size' => 1000,
            'data' => [
                'ref' => 'eA.2fL0-4fxK.jSpw@6ud6-=U7y=AMMiEvxK',
            ],
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/messenger_codes', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }
}
