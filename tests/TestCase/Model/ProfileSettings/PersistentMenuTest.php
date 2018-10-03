<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\ProfileSettings;

use Kerox\Messenger\Model\Common\Button\Nested;
use Kerox\Messenger\Model\Common\Button\PhoneNumber;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Common\Button\WebUrl;
use Kerox\Messenger\Model\ProfileSettings\PersistentMenu;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PersistentMenuTest extends AbstractTestCase
{
    public function testInvalidButton(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Array can only contain instance of Kerox\Messenger\Model\Common\Button\AbstractButton.');

        $persistentMenu = PersistentMenu::create()->setComposerInputDisabled(true)->addButtons([
            'Phone Number' => [
                'payload' => 'PHONE_NUMBER_PAYLOAD',
            ],
        ]);
    }

    public function testInvalidButtonType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Buttons can only be an instance of web_url, postback, nested.');

        $persistentMenu = PersistentMenu::create()->setComposerInputDisabled(true)->addButtons([
            PhoneNumber::create('Phone number', 'PHONE_NUMBER_PAYLOAD'),
            Nested::create('My Account', [
                Postback::create('Pay Bill', 'PAYBILL_PAYLOAD'),
                Postback::create('History', 'HISTORY_PAYLOAD'),
                Postback::create('Contact Info', 'CONTACT_INFO_PAYLOAD'),
            ]),
            WebUrl::create('Latest News', 'http://petershats.parseapp.com/hat-news')->setWebviewHeightRatio('full'),
        ]);
    }
}
