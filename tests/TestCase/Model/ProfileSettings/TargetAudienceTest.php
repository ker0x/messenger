<?php
namespace Kerox\Messenger\Test\TestCase\Model\ProfileSettings;

use Kerox\Messenger\Model\ProfileSettings\TargetAudience;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class TargetAudienceTest extends AbstractTestCase
{

    public function testInvalidTargetAudienceType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$audienceType must be either all, custom, none');
        $targetAudience = TargetAudience::create('partial');
    }
}