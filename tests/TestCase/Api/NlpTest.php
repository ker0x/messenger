<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Api;

use Kerox\Messenger\Api\Nlp;
use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Test\TestCase\ResourceTestCase;

/**
 * Class NlpTest
 *
 * @property Nlp $resource
 */
class NlpTest extends ResourceTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Nlp/success.json');
        $this->mockHandler->append($mockedResponse);

        $this->resource = new Nlp($this->client);
    }

    public function testSetConfig(): void
    {
        $response = $this->resource->config(['nlp_enabled' => true, 'verbose' => false, 'custom_token' => 'abcdef', 'model' => 'fr', 'n_best' => 2]);

        $this->assertTrue($response->isSuccess());
    }

    public function testSetConfigWithBadKey(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('entities is not a valid key. configs must only contain "nlp_enabled, model, custom_token, verbose, n_best".');
        $this->resource->config(['entities' => true]);
    }

    public function testSetConfigWithBadNlpEnabledValue(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('nlp_enabled must be a boolean.');
        $this->resource->config(['nlp_enabled' => 'azerty', 'verbose' => true, 'custom_token' => 'abcdef', 'model' => 'fr', 'n_best' => 1]);
    }

    public function testSetConfigWithBadVerboseValue(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('verbose must be a boolean.');
        $this->resource->config(['nlp_enabled' => true, 'verbose' => 0.01, 'custom_token' => 'abcdef', 'model' => 'fr', 'n_best' => 2]);
    }

    public function testSetConfigWithBadNBestValue(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('n_best must be an integer between 1 and 8.');
        $this->resource->config(['nlp_enabled' => true, 'verbose' => false, 'custom_token' => 'abcdef', 'model' => 'fr', 'n_best' => 9]);
    }
}
