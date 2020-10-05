<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase\Model\Message\Attachment\Template\Element;

use Kerox\Messenger\Exception\MessengerException;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement;
use PHPUnit\Framework\TestCase;

class OpenGraphElementTest extends TestCase
{
    public function testInvalidButton(): void
    {
        $this->expectException(MessengerException::class);
        $this->expectExceptionMessage('Buttons can only be an instance of "web_url"');

        OpenGraphElement::create('https://open.spotify.com/track/7GhIk7Il098yCjg4BQjzvb')
            ->setButtons([
                Postback::create('Learn More', 'LEARN_MORE'),
            ]);
    }
}
