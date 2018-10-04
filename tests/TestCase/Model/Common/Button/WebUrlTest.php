<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Common\Button;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Common\Button\WebUrl;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class WebUrlTest extends AbstractTestCase
{
    public function testButtonWebUrlWithIncorrectWebviewHeightRatio(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('webviewHeightRatio must be either "compact, tall, full".');
        $buttonWebUrl = WebUrl::create('Select Criteria', 'https://petersfancyapparel.com/criteria_selector')
            ->setWebviewHeightRatio('tail');
    }
}
