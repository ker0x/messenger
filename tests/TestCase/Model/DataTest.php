<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model;

use Kerox\Messenger\Model\Data;
use Kerox\Messenger\Model\Data\Value;
use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
    public function testData(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Data/data.json');
        $data = new Data(json_decode($json, true, 512, JSON_THROW_ON_ERROR));

        self::assertSame('page_messages_active_threads_unique', $data->getName());
        self::assertSame('day', $data->getPeriod());
        self::assertSame('Daily unique active threads count by thread fbid', $data->getTitle());
        self::assertSame('Daily: total unique active threads created between users and page.', $data->getDescription());
        self::assertSame('1234567/insights/page_messages_active_threads_unique/day', $data->getId());
        self::assertSame('SHIPPING_UPDATE', $data->getTag());
        self::assertContainsOnlyInstancesOf(Value::class, $data->getValues());
    }
}
