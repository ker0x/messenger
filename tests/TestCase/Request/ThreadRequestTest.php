<?php

namespace Kerox\Messenger\Test\TestCase\Request;

use Kerox\Messenger\Model\ThreadControl;
use Kerox\Messenger\Request\ThreadRequest;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;
use Psr\Http\Message\StreamInterface;

class ThreadRequestTest extends AbstractTestCase
{
    public function testBuildPass()
    {
        $recipient = 123456789;
        $appId = 123456789;

        $control = ThreadControl::create($recipient, $appId);
        $control->setMetadata('String to pass to secondary receiver app');

        $request = new ThreadRequest('me/pass_thread_control', $control);
        $origin = $request->build();

        $expected = json_encode([
            'recipient' => [
                'id' => $recipient,
            ],
            'target_app_id' => $appId,
            'metadata' => 'String to pass to secondary receiver app',
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/pass_thread_control', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }

    public function testBuildTake()
    {
        $recipient = 123456789;

        $control = ThreadControl::create($recipient);
        $control->setMetadata('String to pass to secondary receiver app');

        $request = new ThreadRequest('me/take_thread_control', $control);
        $origin = $request->build();

        $expected = json_encode([
            'recipient' => [
                'id' => $recipient,
            ],
            'metadata' => 'String to pass to secondary receiver app',
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/take_thread_control', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }

    public function testBuildRequest()
    {
        $recipient = 123456789;

        $control = ThreadControl::create($recipient);
        $control->setMetadata('String to pass to secondary receiver app');

        $request = new ThreadRequest('me/request_thread_control', $control);
        $origin = $request->build();

        $expected = json_encode([
            'recipient' => [
                'id' => $recipient,
            ],
            'metadata' => 'String to pass to secondary receiver app',
        ]);

        $this->assertSame('POST', $origin->getMethod());
        $this->assertSame('me/request_thread_control', $origin->getUri()->getPath());
        $this->assertInstanceOf(StreamInterface::class, $origin->getBody());
        $this->assertSame($expected, $origin->getBody()->getContents());
    }
}
