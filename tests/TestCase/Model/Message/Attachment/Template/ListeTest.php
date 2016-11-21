<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Common\Buttons\WebUrl;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ListeElement;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ListeTest extends AbstractTestCase
{

    public function testListeElement()
    {
        $listeElement = new ListeElement('Classic White T-Shirt');
        $listeElement
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/white-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                (new WebUrl('', 'https://peterssendreceiveapp.ngrok.io/view?item=100'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                (new WebUrl('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=100'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            ]);

        $this->assertJsonStringEqualsJsonString('{"title":"Classic White T-Shirt","image_url":"https://peterssendreceiveapp.ngrok.io/img/white-t-shirt.png","subtitle":"100% Cotton, 200% Comfortable","default_action":{"type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/view?item=100","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"},"buttons":[{"title":"Buy","type":"web_url","url":"https://peterssendreceiveapp.ngrok.io/shop?item=100","messenger_extensions":true,"webview_height_ratio":"tall","fallback_url":"https://peterssendreceiveapp.ngrok.io/"}]}', json_encode($listeElement));
    }
}