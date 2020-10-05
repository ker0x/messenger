<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\MediaElement;
use PHPUnit\Framework\TestCase;

class MediaElementTest extends TestCase
{
    public function testInvalidButton(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('Buttons can only be an instance of "web_url".');

        MediaElement::create('https://www.facebook.com/photo.php?fbid=1234567890')
            ->setButtons([
                Postback::create('Learn More', 'LEARN_MORE'),
            ]);
    }

    public function testInvalidType(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('mediaType must be either "image, video".');

        MediaElement::create('https://www.facebook.com/photo.php?fbid=1234567890', 'file')
            ->setButtons([
                Postback::create('Learn More', 'LEARN_MORE'),
            ]);
    }
}
