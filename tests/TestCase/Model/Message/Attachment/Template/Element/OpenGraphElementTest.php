<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment\Element;


use Kerox\Messenger\Model\Common\Buttons\Postback;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\OpenGraphElement;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class OpenGraphElementTest extends AbstractTestCase
{

    public function testInvalidButton()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Buttons can only be an instance of web_url');

        $element = (new OpenGraphElement('https://open.spotify.com/track/7GhIk7Il098yCjg4BQjzvb'))
            ->setButtons([
                (new Postback('Learn More', 'LEARN_MORE'))
            ]);
    }
}