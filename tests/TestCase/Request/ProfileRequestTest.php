<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Model\ProfileSettings;
use Kerox\Messenger\ProfileInterface;
use Kerox\Messenger\Request\ProfileRequest;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;
use Psr\Http\Message\StreamInterface;

class ProfileRequestTest extends AbstractTestCase
{
    public function testBuildPostRequest()
    {
        $settings = ProfileSettings::create();
        $settings->addGreetings([
            new ProfileSettings\Greeting('Hello world')
        ]);

        $request = new ProfileRequest('me/messenger_profile', $settings);
        $origin = $request->build('post');

        $expected = json_encode([
            'greeting' => [
                [
                    'locale' => 'default',
                    'text' => 'Hello world',
                ]
            ]
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/messenger_profile', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }

    public function testBuildGetRequest()
    {
        $settings = [
            ProfileInterface::GREETING,
            ProfileInterface::GET_STARTED,
        ];

        $request = new ProfileRequest('me/messenger_profile', implode(',', $settings));
        $origin = $request->build('get');

        $expected = http_build_query([
            'fields' => implode(',', $settings),
        ]);

        $this->assertSame('GET', $origin->getMethod());
        $this->assertSame('me/messenger_profile', $origin->getUri()->getPath());
        $this->assertSame($expected, $origin->getUri()->getQuery());
    }

    public function testBuildDeleteRequest()
    {
        $settings = [
            ProfileInterface::GREETING,
            ProfileInterface::GET_STARTED,
        ];

        $request = new ProfileRequest('me/messenger_profile', $settings);
        $origin = $request->build('delete');

        $expected = json_encode([
            'fields' => [
                ProfileInterface::GREETING,
                ProfileInterface::GET_STARTED,
            ]
        ]);

        $this->assertSame('DELETE', $origin->getMethod());
        $this->assertSame('me/messenger_profile', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }
}
