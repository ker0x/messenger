<?php
namespace Kerox\Messenger\Test\TestCase\Model;

use Kerox\Messenger\Model\Data;
use Kerox\Messenger\Model\Data\Value;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class DataTest extends AbstractTestCase
{

    public function testData()
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Data/data.json');
        $data = new Data(json_decode($json, true));

        $this->assertEquals('page_messages_active_threads_unique', $data->getName());
        $this->assertEquals('day', $data->getPeriod());
        $this->assertEquals('Daily unique active threads count by thread fbid', $data->getTitle());
        $this->assertEquals('Daily: total unique active threads created between users and page.', $data->getDescription());
        $this->assertEquals('1234567/insights/page_messages_active_threads_unique/day', $data->getId());
        $this->assertEquals('SHIPPING_UPDATE', $data->getTag());
        $this->assertContainsOnlyInstancesOf(Value::class, $data->getValues());
    }
}