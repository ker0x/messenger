<?php

declare(strict_types=1);

namespace Kerox\Messenger\Test\TestCase;

use Kerox\Messenger\Api\Broadcast;
use Kerox\Messenger\Api\Code;
use Kerox\Messenger\Api\Insights;
use Kerox\Messenger\Api\Nlp;
use Kerox\Messenger\Api\Persona;
use Kerox\Messenger\Api\Profile;
use Kerox\Messenger\Api\Send;
use Kerox\Messenger\Api\Tag;
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

    public function setUp(): void
    {
        $this->messenger = new Messenger('4321dcba', 'abcd1234', '1234abcd');
    }

    public function testGetInstanceOfApi(): void
    {
        $this->assertInstanceOf(Send::class, $this->messenger->send());
        $this->assertInstanceOf(User::class, $this->messenger->user());
        $this->assertInstanceOf(Webhook::class, $this->messenger->webhook());
        $this->assertInstanceOf(Code::class, $this->messenger->code());
        $this->assertInstanceOf(Insights::class, $this->messenger->insights());
        $this->assertInstanceOf(Profile::class, $this->messenger->profile());
        $this->assertInstanceOf(Tag::class, $this->messenger->tag());
        $this->assertInstanceOf(Thread::class, $this->messenger->thread());
        $this->assertInstanceOf(Nlp::class, $this->messenger->nlp());
        $this->assertInstanceOf(Broadcast::class, $this->messenger->broadcast());
        $this->assertInstanceOf(Persona::class, $this->messenger->persona());
    }

    public function tearDown(): void
    {
        unset($this->messenger);
    }
}
