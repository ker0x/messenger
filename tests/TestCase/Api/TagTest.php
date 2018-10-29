<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase;

use Kerox\Messenger\Api\Tag;
use Kerox\Messenger\Model\Data;

/**
 * Class TagTest
 *
 * @property Tag $resource
 */
class TagTest extends ResourceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $mockedResponse = $this->createMockedResponse(__DIR__ . '/../../Mocks/Response/Tag/tag.json');
        $this->mockHandler->append($mockedResponse);

        $this->resource = new Tag($this->client);
    }

    public function testGetTag(): void
    {
        $response = $this->resource->get();

        $this->assertContainsOnlyInstancesOf(Data::class, $response->getData());
        $this->assertEquals($this->getData(), $response->getData());
    }

    private function getData(): array
    {
        $dataList = json_decode(file_get_contents(__DIR__ . '/../../Mocks/Response/Tag/tag.json'), true);

        return array_map(function (array $row) {
            return Data::create($row);
        }, $dataList['data']);
    }
}
