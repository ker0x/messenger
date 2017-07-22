<?php
namespace Kerox\Messenger\Test\TestCase\Model\Common\Buttons;

use Kerox\Messenger\Model\Common\Buttons\WebUrl;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class WebUrlTest extends AbstractTestCase
{

    public function testButtonWebUrlWithIncorrectWenviewHeightRatio()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$webviewHeightRatio must be either compact, tall, full');
        $buttonWebUrl = new WebUrl('Select Criteria', 'https://petersfancyapparel.com/criteria_selector');
        $buttonWebUrl
            ->setWebviewHeightRatio('tail');
    }
}