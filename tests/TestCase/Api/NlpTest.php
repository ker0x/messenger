<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Nlp;
use Kerox\Messenger\Exception\MessengerException;
use PHPUnit\Framework\TestCase;

class NlpTest extends TestCase
{
    /**
     * @var \Kerox\Messenger\Api\Nlp
     */
    protected $nlpApi;

    public function setUp(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Nlp/success.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $this->nlpApi = new Nlp('abcd1234', $client);
    }

    public function testSetConfig(): void
    {
        $response = $this->nlpApi->config(['nlp_enabled' => true, 'verbose' => false, 'custom_token' => 'abcdef', 'model' => 'fr', 'n_best' => 2]);

        self::assertTrue($response->isSuccess());
    }

    public function testSetConfigWithInvalidKey(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('entities is not a valid key. configs must only contain "nlp_enabled, model, custom_token, verbose, n_best".');
        $this->nlpApi->config(['entities' => true]);
    }

    public function testSetConfigWithInvalidNlpEnabledValue(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('nlp_enabled must be a boolean.');
        $this->nlpApi->config(['nlp_enabled' => 'azerty', 'verbose' => true, 'custom_token' => 'abcdef', 'model' => 'fr', 'n_best' => 1]);
    }

    public function testSetConfigWithInvalidVerboseValue(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('verbose must be a boolean.');
        $this->nlpApi->config(['nlp_enabled' => true, 'verbose' => 0.01, 'custom_token' => 'abcdef', 'model' => 'fr', 'n_best' => 2]);
    }

    public function testSetConfigWithInvalidNBestValue(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('n_best must be an integer between 1 and 8.');
        $this->nlpApi->config(['nlp_enabled' => true, 'verbose' => false, 'custom_token' => 'abcdef', 'model' => 'fr', 'n_best' => 9]);
    }
}
