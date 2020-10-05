<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Data;

use Kerox\Messenger\Model\Data\Value;
use PHPUnit\Framework\TestCase;

class ValueTest extends TestCase
{
    public function testThreadsValue(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Data/threads_value.json');
        $value = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $threadsValue = Value::create($value['value'], $value['end_time']);

        self::assertSame(83111, $threadsValue->getValue());
        self::assertSame('2017-02-02T08:00:00+0000', $threadsValue->getEndTime(false));
        self::assertInstanceOf(\DateTime::class, $threadsValue->getEndTime());
    }

    public function testFeedbackValue(): void
    {
        $json = file_get_contents(__DIR__ . '/../../../Mocks/Data/feedback_value.json');
        $value = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $feedbackValue = Value::create($value['value'], $value['end_time']);

        self::assertSame([
            'TURN_ON' => 40,
            'TURN_OFF' => 167,
            'DELETE' => 720,
            'OTHER' => 0,
            'REPORT_SPAM' => 0,
        ], $feedbackValue->getValue());
        self::assertSame('2017-02-02T08:00:00+0000', $feedbackValue->getEndTime(false));
        self::assertInstanceOf(\DateTime::class, $feedbackValue->getEndTime());
    }
}
