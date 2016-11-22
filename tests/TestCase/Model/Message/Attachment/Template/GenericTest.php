<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Common\Buttons\Postback;
use Kerox\Messenger\Model\Common\Buttons\WebUrl;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\GenericElement;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class GenericTest extends AbstractTestCase
{

    public function testGenericElement()
    {
        $genericElement = new GenericElement('Welcome to Peter\'s Hats');
        $genericElement
            ->setItemUrl('https://petersfancybrownhats.com')
            ->setImageUrl('https://petersfancybrownhats.com/company_image.png')
            ->setSubtitle('We\'ve got the right hat for everyone.')
            ->setButtons([
                new WebUrl('View Website', 'https://petersfancybrownhats.com'),
                new Postback('Start Chatting', 'DEVELOPER_DEFINED_PAYLOAD'),
            ]);

        $this->assertJsonStringEqualsJsonString('{"title":"Welcome to Peter\'s Hats","item_url":"https://petersfancybrownhats.com","image_url":"https://petersfancybrownhats.com/company_image.png","subtitle":"We\'ve got the right hat for everyone.","buttons":[{"type":"web_url","url":"https://petersfancybrownhats.com","title":"View Website"},{"type":"postback","title":"Start Chatting","payload":"DEVELOPER_DEFINED_PAYLOAD"}]}', json_encode($genericElement));
    }
}