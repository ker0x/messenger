<?php
namespace Kerox\Messenger\Test\TestCase;

use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Api\Thread;
use Kerox\Messenger\Api\User;
use Kerox\Messenger\Api\Webhook;
use Kerox\Messenger\Messenger;

class MessengerTest extends AbstractTestCase
{

    /**
     * @var Messenger
     */
    protected $messenger;

    public function setUp()
    {
        $this->messenger = new Messenger('4321dcba', 'abcd1234');
    }

    public function testGetInstanceOfApi()
    {
        $this->assertInstanceOf(Send::class, $this->messenger->send());
        $this->assertInstanceOf(Thread::class, $this->messenger->thread());
        $this->assertInstanceOf(User::class, $this->messenger->user());
    }

    public function testGetWebhookApi()
    {
        $this->assertInstanceOf(Webhook::class, $this->messenger->webhook('abvd1234', '4321dcba'));
        $this->assertInstanceOf(Webhook::class, $this->messenger->webhook());
    }

    public function tearDown()
    {
        unset($this->messenger);
    }
}