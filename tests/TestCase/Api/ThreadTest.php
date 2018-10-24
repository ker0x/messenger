<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase;

use Kerox\Messenger\Api\Thread;
use Kerox\Messenger\Model\ThreadControl;

/**
 * Class ThreadTest
 *
 * @property Thread $resource
 */
class ThreadTest extends ResourceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Thread/success.json');
        $this->mockHandler->append($mockedResponse);

        $this->resource = new Thread($this->client);
    }

    public function testPassThreadControl(): void
    {
        $passThreadControl = ThreadControl::create(1234567890, 123456789);
        $passThreadControl->setMetadata('additional content that the caller wants to set');

        $response = $this->resource->pass($passThreadControl);

        $this->assertTrue($response->isSuccess());
    }

    public function testTakeThreadControl(): void
    {
        $takeThreadControl = ThreadControl::create(1234567890);
        $takeThreadControl->setMetadata('additional content that the caller wants to set');

        $response = $this->resource->take($takeThreadControl);

        $this->assertTrue($response->isSuccess());
    }

    public function testRequestThreadControl(): void
    {
        $requestThreadControl = ThreadControl::create(1234567890);
        $requestThreadControl->setMetadata('additional content that the caller wants to set');

        $response = $this->resource->request($requestThreadControl);

        $this->assertTrue($response->isSuccess());
    }
}
