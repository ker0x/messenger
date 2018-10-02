<?php
namespace Kerox\Messenger\Test\TestCase\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Model\Message\Attachment\Image;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary;
use Kerox\Messenger\Model\Message\Attachment\Template\ReceiptTemplate;
use Kerox\Messenger\Request\SendRequest;
use Kerox\Messenger\SendInterface;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class SendTest extends AbstractTestCase
{

    /**
     * @var \Kerox\Messenger\Api\Send
     */
    protected $sendApi;

    public function setUp()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/basic.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $this->sendApi = new Send('abcd1234', $client);
    }

    public function testSendTextToUser()
    {
        $response = $this->sendApi->message('1008372609250235', 'Hello World!');

        $this->assertEquals('1008372609250235', $response->getRecipientId());
        $this->assertEquals('mid.1456970487936:c34767dfe57ee6e339', $response->getMessageId());
    }

    public function testSendMessageToUser()
    {
        $message = $this->getReceipt();

        $response = $this->sendApi->message('1008372609250235', $message, [
            'messaging_type' => SendInterface::MESSAGING_TYPE_RESPONSE,
            'notification_type' => SendInterface::NOTIFICATION_TYPE_REGULAR,
            'tag' => SendInterface::TAG_ACCOUNT_UPDATE
        ]);

        $this->assertEquals('1008372609250235', $response->getRecipientId());
        $this->assertEquals('mid.1456970487936:c34767dfe57ee6e339', $response->getMessageId());
    }

    public function testSendAttachmentToUser()
    {
        $message = $this->getReceipt();

        $response = $this->sendApi->message('1008372609250235', $message);

        $this->assertEquals('1008372609250235', $response->getRecipientId());
        $this->assertEquals('mid.1456970487936:c34767dfe57ee6e339', $response->getMessageId());
    }

    public function testBadMessage()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('message must be a string or an instance of Kerox\Messenger\Model\Message or Kerox\Messenger\Model\Message\Attachment.');
        $this->sendApi->message('1008372609250235', 1234);
    }

    public function testSendActionToUser()
    {
        $response = $this->sendApi->action('1008372609250235', 'typing_on');

        $this->assertEquals('1008372609250235', $response->getRecipientId());
    }

    public function testSendMessageWithBadOptionsKey()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Only messaging_type, notification_type, tag are allowed keys for options.');
        $this->sendApi->message('1008372609250235', 'Hello World!', [
            'notification_type' => SendInterface::NOTIFICATION_TYPE_REGULAR,
            'action_type' => SendRequest::REQUEST_TYPE_ACTION
        ]);
    }

    public function testBadActionType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('action must be either typing_on, typing_off, mark_seen');
        $this->sendApi->action('1008372609250235', 'typing_seen');
    }

    public function testBadMessagingType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('messagingType must be either RESPONSE, MESSAGE_TAG, NON_PROMOTIONAL_SUBSCRIPTION, UPDATE');
        $this->sendApi->message('1008372609250235', 'Hello World!', [
            'messaging_type' => 'PROMOTIONAL_SUBSCRIPTION'
        ]);
    }

    public function testBadNotificationType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('notificationType must be either REGULAR, SILENT_PUSH, NO_PUSH');
        $this->sendApi->message('1008372609250235', 'Hello World!', [
            'notification_type' => 'UPDATE'
        ]);
    }

    public function testBadTagType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('tag must be either BUSINESS_PRODUCTIVITY, COMMUNITY_ALERT, CONFIRMED_EVENT_REMINDER, NON_PROMOTIONAL_SUBSCRIPTION, PAIRING_UPDATE, APPLICATION_UPDATE, ACCOUNT_UPDATE, PAYMENT_UPDATE, PERSONAL_FINANCE_UPDATE, SHIPPING_UPDATE, RESERVATION_UPDATE, ISSUE_RESOLUTION, APPOINTMENT_UPDATE, GAME_EVENT, TRANSPORTATION_UPDATE, FEATURE_FUNCTIONALITY_UPDATE, TICKET_UPDATE');
        $this->sendApi->message('1008372609250235', 'Hello World!', [
            'notification_type' => SendInterface::NOTIFICATION_TYPE_REGULAR,
            'tag' => 'INVOICE_UPDATE',
        ]);
    }

    public function testBadMessageForTagIssueResolution()
    {
        $message = $this->getReceipt();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('message must be an instance of Kerox\Messenger\Model\Message\Attachment\Template\GenericTemplate if tag is set to ISSUE_RESOLUTION.');
        $this->sendApi->message('1008372609250235', $message, [
            'notification_type' => SendInterface::NOTIFICATION_TYPE_REGULAR,
            'tag' => SendInterface::TAG_ISSUE_RESOLUTION,
        ]);
    }

    public function testSendAttachment()
    {
        $bodyResponse = file_get_contents(__DIR__ . '/../../Mocks/Response/Send/attachment.json');
        $mockedResponse = new MockHandler([
            new Response(200, [], $bodyResponse),
        ]);

        $handler = HandlerStack::create($mockedResponse);
        $client = new Client([
            'handler' => $handler
        ]);

        $sendApi = new Send('abcd1234', $client);

        $response = $sendApi->attachment(new Image('http://www.messenger-rocks.com/image.jpg', true));

        $this->assertEquals('1854626884821032', $response->getAttachmentId());
        $this->assertNull($response->getRecipientId());
        $this->assertNull($response->getMessageId());
    }

    public function tearDown()
    {
        unset($this->sendApi);
    }

    private function getReceipt()
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
            ->setAddress(new Address('1 Hacker Way', 'Menlo Park', '94025', 'CA', 'US'))
            ->setAdjustments([
                Adjustment::create()->setName('New Customer Discount')->setAmount(20),
                Adjustment::create()->setName('$10 Off Coupon')->setAmount(10),
            ]);

        return $receipt;
    }
}
