<?php

declare(strict_types=1);

namespace Kerox\Messenger\Tests\TestCase;

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
use PHPUnit\Framework\TestCase;

class MessengerTest extends TestCase
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
        self::assertInstanceOf(Send::class, $this->messenger->send());
        self::assertInstanceOf(User::class, $this->messenger->user());
        self::assertInstanceOf(Webhook::class, $this->messenger->webhook());
        self::assertInstanceOf(Code::class, $this->messenger->code());
        self::assertInstanceOf(Insights::class, $this->messenger->insights());
        self::assertInstanceOf(Profile::class, $this->messenger->profile());
        self::assertInstanceOf(Tag::class, $this->messenger->tag());
        self::assertInstanceOf(Thread::class, $this->messenger->thread());
        self::assertInstanceOf(Nlp::class, $this->messenger->nlp());
        self::assertInstanceOf(Broadcast::class, $this->messenger->broadcast());
        self::assertInstanceOf(Persona::class, $this->messenger->persona());
    }

    public function tearDown(): void
    {
        unset($this->messenger);
    }
}
