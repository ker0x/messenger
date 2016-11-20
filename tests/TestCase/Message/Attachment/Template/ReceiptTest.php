<?php
namespace Kerox\Messenger\Test\TestCase\Message\Attachment\Template;

use Kerox\Messenger\Message\Attachment\Template\Element\ReceiptElement;
use Kerox\Messenger\Message\Attachment\Template\Receipt\Address;
use Kerox\Messenger\Message\Attachment\Template\Receipt\Adjustment;
use Kerox\Messenger\Message\Attachment\Template\Receipt\Summary;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class ReceiptTest extends AbstractTestCase
{

    public function testReceiptAddress()
    {
        $receiptAddress = new Address('1 Hacker Way', 'Menlo Park', '94025', 'CA', 'US');
        $receiptAddress->setAdditionalStreet('Apt 2');

        $this->assertJsonStringEqualsJsonString('{"street_1":"1 Hacker Way","street_2":"Apt 2","city":"Menlo Park","postal_code":"94025","state":"CA","country":"US"}', json_encode($receiptAddress));
    }

    public function testReceiptAdjustment()
    {
        $receiptAdjustment = new Adjustment();
        $receiptAdjustment
            ->setName('New Customer Discount')
            ->setAmount(20);

        $this->assertJsonStringEqualsJsonString('{"name":"New Customer Discount","amount":20}', json_encode($receiptAdjustment));
    }

    public function testReceiptElement()
    {
        $receiptElement = new ReceiptElement('Classic White T-Shirt', 50);
        $receiptElement
            ->setSubtitle('100% Soft and Luxurious Cotton')
            ->setQuantity(2)
            ->setCurrency('USD')
            ->setImageUrl('http://petersapparel.parseapp.com/img/whiteshirt.png');

        $this->assertJsonStringEqualsJsonString('{"title":"Classic White T-Shirt","subtitle":"100% Soft and Luxurious Cotton","quantity":2,"price":50,"currency":"USD","image_url":"http://petersapparel.parseapp.com/img/whiteshirt.png"}', json_encode($receiptElement));
    }

    public function testReceiptSummary()
    {
        $receiptSummary = new Summary(56.14);
        $receiptSummary
            ->setSubtotal(75.00)
            ->setShippingCost(4.95)
            ->setTotalTax(6.19);

        $this->assertJsonStringEqualsJsonString('{"subtotal":75.00,"shipping_cost":4.95,"total_tax":6.19,"total_cost":56.14}', json_encode($receiptSummary));
    }
}