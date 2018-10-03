<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase\Model;

use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary;
use Kerox\Messenger\Model\Message\Attachment\Template\ReceiptTemplate;
use Kerox\Messenger\Model\Message\QuickReply;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class MessageTest extends AbstractTestCase
{
    public function testMessageWithText(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Message/text.json');
        $message = Message::create('hello, world!');

        $this->assertJsonStringEqualsJsonString($json, json_encode($message));
    }

    public function testMessageWithReceipt(): void
    {
        $elements = [
            ReceiptElement::create('Classic White T-Shirt', 50)
                ->setSubtitle('100% Soft and Luxurious Cotton')
                ->setQuantity(2)
                ->setCurrency('USD')
                ->setImageUrl('http://petersapparel.parseapp.com/img/whiteshirt.png'),
            ReceiptElement::create('Classic Gray T-Shirt', 25)
                ->setSubtitle('100% Soft and Luxurious Cotton')
                ->setQuantity(1)
                ->setCurrency('USD')
                ->setImageUrl('http://petersapparel.parseapp.com/img/grayshirt.png'),
        ];

        $summary = Summary::create(56.14)
            ->setSubtotal(75.00)
            ->setShippingCost(4.95)
            ->setTotalTax(6.19);

        $receipt = ReceiptTemplate::create('Stephane Crozatier', '12345678902', 'USD', 'Visa 2345', $elements, $summary)
            ->setTimestamp('1428444852')
            ->setOrderUrl('http://petersapparel.parseapp.com/order?order_id=123456')
            ->setAddress(Address::create('1 Hacker Way', 'Menlo Park', '94025', 'CA', 'US'))
            ->setAdjustments([
                Adjustment::create()
                    ->setName('New Customer Discount')
                    ->setAmount(20),
                Adjustment::create()
                    ->setName('$10 Off Coupon')
                    ->setAmount(10),
            ]);

        $json = file_get_contents(__DIR__ . '/../../Mocks/Message/receipt.json');
        $message = Message::create($receipt);

        $this->assertJsonStringEqualsJsonString($json, json_encode($message));
    }

    public function testMessageWithQuickReplies(): void
    {
        $json = file_get_contents(__DIR__ . '/../../Mocks/Message/quick_reply.json');

        $message = Message::create('Pick a color:')
            ->setQuickReplies([
                QuickReply::create()
                    ->setTitle('Red')
                    ->setPayload('DEVELOPER_DEFINED_PAYLOAD_FOR_PICKING_RED')
                    ->setImageUrl('http://petersfantastichats.com/img/red.png'),
                QuickReply::create()
                    ->setTitle('Green')
                    ->setPayload('DEVELOPER_DEFINED_PAYLOAD_FOR_PICKING_GREEN')
                    ->setImageUrl('http://petersfantastichats.com/img/green.png'),
            ])
            ->addQuickReply(QuickReply::create(QuickReply::CONTENT_TYPE_LOCATION))
            ->setMetadata('some metadata');

        $this->assertJsonStringEqualsJsonString($json, json_encode($message));
    }

    public function testMessageWithInvalidArgument(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('$message must be a string or an instance of Attachment.');
        $message = new Message(123456);
    }

    public function testMessageWithInvalidQuickReplies(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Array can only contain instance of QuickReply.');
        $message = Message::create('Pick a color:')
            ->setQuickReplies([
                QuickReply::create()
                    ->setTitle('Red')
                    ->setPayload('DEVELOPER_DEFINED_PAYLOAD_FOR_PICKING_RED')
                    ->setImageUrl('http://petersfantastichats.com/img/red.png'),
                QuickReply::create()
                    ->setTitle('Green')
                    ->setPayload('DEVELOPER_DEFINED_PAYLOAD_FOR_PICKING_GREEN')
                    ->setImageUrl('http://petersfantastichats.com/img/green.png'),
                'Hello',
            ]);
    }
}
