<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment\Element;

use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\MediaElement;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class MediaElementTest extends AbstractTestCase
{
    public function testInvalidButton(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Buttons can only be an instance of web_url');

        $element = MediaElement::create('https://www.facebook.com/photo.php?fbid=1234567890')
            ->setButtons([
                Postback::create('Learn More', 'LEARN_MORE'),
            ]);
    }

    public function testInvalidType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$mediaType must be either image, video');

        $element = MediaElement::create('https://www.facebook.com/photo.php?fbid=1234567890', 'file')
            ->setButtons([
                Postback::create('Learn More', 'LEARN_MORE'),
            ]);
    }
}
