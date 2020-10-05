<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\ProfileSettings;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\ProfileSettings\TargetAudience;
use PHPUnit\Framework\TestCase;

class TargetAudienceTest extends TestCase
{
    public function testInvalidTargetAudienceType(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('audienceType must be either "all, custom, none".');
        TargetAudience::create('partial');
    }
}
