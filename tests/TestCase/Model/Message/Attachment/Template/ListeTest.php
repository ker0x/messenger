<?php
namespace Kerox\Messenger\Test\TestCase\Model\Message\Attachment\Template;

use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Common\Button\WebUrl;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ListeElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Liste;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ListeTest extends AbstractTestCase
{

    public function testInvalidTopElementStyle()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$topElementStyle must be either large, compact');

        $element1 = (new ListeElement('Classic White T-Shirt'))
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

        $element2 = (new ListeElement('Classic Blue T-Shirt'))
            ->setImageUrl('https://peterssendreceiveapp.ngrok.io/img/blue-t-shirt.png')
            ->setSubtitle('100% Cotton, 200% Comfortable')
            ->setDefaultAction(
                (new WebUrl('', 'https://peterssendreceiveapp.ngrok.io/view?item=101'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            )
            ->setButtons([
                (new WebUrl('Buy', 'https://peterssendreceiveapp.ngrok.io/shop?item=101'))
                    ->setMessengerExtension(true)
                    ->setWebviewHeightRatio(WebUrl::RATIO_TYPE_TALL)
                    ->setFallbackUrl('https://peterssendreceiveapp.ngrok.io/')
            ]);

        $liste = new Liste([$element1, $element2]);
        $liste
            ->setTopElementStyle('x-large')
            ->setButtons([
                new Postback('View More', 'payload')
            ]);
    }
}