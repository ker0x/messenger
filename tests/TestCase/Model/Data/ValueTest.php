<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Data;

use Kerox\Messenger\Model\Data\Value;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ValueTest extends AbstractTestCase
{
    public function testThreadsValue(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Data/threads_value.json');
        $value = json_decode($json, true);

        $threadsValue = Value::create($value['value'], $value['end_time']);

        $this->assertSame(83111, $threadsValue->getValue());
        $this->assertSame('2017-02-02T08:00:00+0000', $threadsValue->getEndTime(false));
        $this->assertInstanceOf(\DateTime::class, $threadsValue->getEndTime());
    }

    public function testFeedbackValue(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Data/feedback_value.json');
        $value = json_decode($json, true);

        $feedbackValue = Value::create($value['value'], $value['end_time']);

        $this->assertSame([
            'TURN_ON' => 40,
            'TURN_OFF' => 167,
            'DELETE' => 720,
            'OTHER' => 0,
            'REPORT_SPAM' => 0,
        ], $feedbackValue->getValue());
        $this->assertSame('2017-02-02T08:00:00+0000', $feedbackValue->getEndTime(false));
        $this->assertInstanceOf(\DateTime::class, $feedbackValue->getEndTime());
    }
}
