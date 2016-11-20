<?php
namespace Kerox\Messenger\Test\TestCase\Message;

use Kerox\Messenger\Message\Attachment\Template\Receipt;
use Kerox\Messenger\Message\Attachment\Template\Receipt\Address;
use Kerox\Messenger\Message\Attachment\Template\Receipt\Adjustment;
use Kerox\Messenger\Message\Attachment\Template\Element\ReceiptElement;
use Kerox\Messenger\Message\Attachment\Template\Receipt\Summary;
use Kerox\Messenger\Message\Message;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class MessageTest extends AbstractTestCase
{

    public function testMessageWithReceipt()
    {
        $elements = [
            (new ReceiptElement('Classic White T-Shirt', 50))->setSubtitle('100% Soft and Luxurious Cotton')->setQuantity(2)->setCurrency('USD')->setImageUrl('http://petersapparel.parseapp.com/img/whiteshirt.png'),
            (new ReceiptElement('Classic Gray T-Shirt', 25))->setSubtitle('100% Soft and Luxurious Cotton')->setQuantity(1)->setCurrency('USD')->setImageUrl('http://petersapparel.parseapp.com/img/grayshirt.png'),
        ];

        $summary = new Summary(56.14);
        $summary
            ->setSubtotal(75.00)
            ->setShippingCost(4.95)
            ->setTotalTax(6.19);

        $receipt = new Receipt('Stephane Crozatier', '12345678902', 'USD', 'Visa 2345', $elements, $summary);
        $receipt
            ->setTimestamp('1428444852')
            ->setOrderUrl('http://petersapparel.parseapp.com/order?order_id=123456')
            ->setAddress(new Address('1 Hacker Way', 'Menlo Park', '94025', 'CA', 'US'))
            ->setAdjustments([
                (new Adjustment())->setName('New Customer Discount')->setAmount(20),
                (new Adjustment())->setName('$10 Off Coupon')->setAmount(10),
            ]);

        $message = new Message($receipt);

        $this->assertJsonStringEqualsJsonString('{"attachment":{"type":"template","payload":{"template_type":"receipt","recipient_name":"Stephane Crozatier","order_number":"12345678902","currency":"USD","payment_method":"Visa 2345","order_url":"http://petersapparel.parseapp.com/order?order_id=123456","timestamp":"1428444852","elements":[{"title":"Classic White T-Shirt","subtitle":"100% Soft and Luxurious Cotton","quantity":2,"price":50,"currency":"USD","image_url":"http://petersapparel.parseapp.com/img/whiteshirt.png"},{"title":"Classic Gray T-Shirt","subtitle":"100% Soft and Luxurious Cotton","quantity":1,"price":25,"currency":"USD","image_url":"http://petersapparel.parseapp.com/img/grayshirt.png"}],"address":{"street_1":"1 Hacker Way","city":"Menlo Park","postal_code":"94025","state":"CA","country":"US"},"summary":{"subtotal":75.00,"shipping_cost":4.95,"total_tax":6.19,"total_cost":56.14},"adjustments":[{"name":"New Customer Discount","amount":20},{"name":"$10 Off Coupon","amount":10}]}}}', json_encode($message));
    }
}