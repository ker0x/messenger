<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Common\Button;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Common\Button\WebUrl;
use PHPUnit\Framework\TestCase;

class WebUrlTest extends TestCase
{
    public function testButtonWebUrlWithIncorrectWebviewHeightRatio(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('webviewHeightRatio must be either "compact, tall, full".');

        WebUrl::create('Select Criteria', 'https://petersfancyapparel.com/criteria_selector')
            ->setWebviewHeightRatio('tail');
    }
}
