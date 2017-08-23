<?php
namespace Kerox\Messenger\Test\TestCase;

use Kerox\Messenger\Api\Code;
use Kerox\Messenger\Api\Insights;
use Kerox\Messenger\Api\Profile;
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
        $this->messenger = new Messenger('4321dcba', 'abcd1234', '1234abcd');
    }

    public function testGetInstanceOfApi()
    {
        $this->assertInstanceOf(Send::class, $this->messenger->send());
        $this->assertInstanceOf(User::class, $this->messenger->user());
        $this->assertInstanceOf(Webhook::class, $this->messenger->webhook());
        $this->assertInstanceOf(Code::class, $this->messenger->code());
        $this->assertInstanceOf(Insights::class, $this->messenger->insights());
        $this->assertInstanceOf(Profile::class, $this->messenger->profile());
    }

    public function tearDown()
    {
        unset($this->messenger);
    }
}