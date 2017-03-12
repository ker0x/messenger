<?php
namespace Kerox\Messenger\Test\TestCase;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Code;
use Kerox\Messenger\Request\CodeRequest;
use Kerox\Messenger\Response\CodeResponse;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class CodeTest extends AbstractTestCase
{

    /**
     * @var \Kerox\Messenger\Api\Code
     */
    protected $codeApi;

    public function setUp()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Code/code.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $this->codeApi = new Code('abcd1234', $client);
    }

    public function testRequestCode()
    {
        $response = $this->codeApi->request();

        $this->assertInstanceOf(CodeResponse::class, $response);
        $this->assertEquals('https://scontent.xx.fbcdn.net/v/t39.8917-6/16685555_1672240442792330_5569294125766803456_n.png?oh=eb8cf65a7a7a5808b24e55527b366dd0&oe=592BBFCC', $response->getUri());
    }

    public function testSmallImageSize()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$imageSize must be between 100 and 2000');
        $this->codeApi->request(99, 'standard');
    }

    public function testBigImageSize()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$imageSize must be between 100 and 2000');
        $this->codeApi->request(2001, 'standard');
    }

    public function testBadCodeType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$codeType must be either standard');
        $this->codeApi->request(2000, 'stretch');
    }

    public function tearDown()
    {
        unset($this->codeApi);
    }
}
