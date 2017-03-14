<?php
namespace Kerox\Messenger\Test\TestCase\Model\Data;

use Kerox\Messenger\Model\Data\Value;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ValueTest extends AbstractTestCase
{

    public function testThreadsValue()
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Data/threads_value.json');
        $value = json_decode($json, true);

        $threadsValue = new Value($value['value'], $value['end_time']);

        $this->assertEquals(83111, $threadsValue->getValue());
        $this->assertEquals('2017-02-02T08:00:00+0000', $threadsValue->getEndTime(false));
        $this->assertInstanceOf(\DateTime::class, $threadsValue->getEndTime());
    }

    public function testFeedbackValue()
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Data/feedback_value.json');
        $value = json_decode($json, true);

        $feedbackValue = new Value($value['value'], $value['end_time']);

        $this->assertEquals([
            'TURN_ON' => 40,
            'TURN_OFF' => 167,
            'DELETE' => 720,
            'OTHER' => 0,
            'REPORT_SPAM' => 0,
        ], $feedbackValue->getValue());
        $this->assertEquals('2017-02-02T08:00:00+0000', $feedbackValue->getEndTime(false));
        $this->assertInstanceOf(\DateTime::class, $feedbackValue->getEndTime());
    }
}