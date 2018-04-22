<?php
namespace Kerox\Messenger\Test\TestCase;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Tag;
use Kerox\Messenger\Model\Data;
use Kerox\Messenger\Response\TagResponse;

class TagTest extends AbstractTestCase
{

    /**
     * @var \Kerox\Messenger\Api\Tag
     */
    protected $tagApi;

    public function setUp()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Tag/tag.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $this->tagApi = new Tag('abcd1234', $client);
    }

    public function testGetTag()
    {
        $response = $this->tagApi->get();

        $this->assertContainsOnlyInstancesOf(Data::class, $response->getData());
        $this->assertEquals($this->getData(), $response->getData());
    }

    private function getData()
    {
        $datas = json_decode(file_get_contents(__DIR__ . '/../../Mocks/Response/Tag/tag.json'), true);

        $tags = [];
        foreach ($datas['data'] as $data) {
            $tags[] = Data::create($data);
        }

        return $tags;
    }
}
