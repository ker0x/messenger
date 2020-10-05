<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Tag;
use Kerox\Messenger\Model\Data;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    /**
     * @var \Kerox\Messenger\Api\Tag
     */
    protected $tagApi;

    public function setUp(): void
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Tag/tag.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler,
        ]);

        $this->tagApi = new Tag('abcd1234', $client);
    }

    public function testGetTag(): void
    {
        $response = $this->tagApi->get();

        self::assertContainsOnlyInstancesOf(Data::class, $response->getData());
        self::assertEquals($this->getData(), $response->getData());
    }

    private function getData()
    {
        $datas = json_decode(file_get_contents(__DIR__ . '/../../Mocks/Response/Tag/tag.json'), true, 512, JSON_THROW_ON_ERROR);

        $tags = [];
        foreach ($datas['data'] as $data) {
            $tags[] = Data::create($data);
        }

        return $tags;
    }
}
