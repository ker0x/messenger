<?php
namespace Kerox\Messenger\Test\TestCase\Callback;

use Kerox\Messenger\Callback\AccountLinkingEvent;
use Kerox\Messenger\Callback\CallbackEventFactory;
use Kerox\Messenger\Callback\DeliveryEvent;
use Kerox\Messenger\Callback\MessageEchoEvent;
use Kerox\Messenger\Callback\MessageEvent;
use Kerox\Messenger\Callback\OptinEvent;
use Kerox\Messenger\Callback\PostbackEvent;
use Kerox\Messenger\Callback\RawEvent;
use Kerox\Messenger\Callback\ReadEvent;
use Kerox\Messenger\Model\Callback\AccountLinking;
use Kerox\Messenger\Model\Callback\Delivery;
use Kerox\Messenger\Model\Callback\Message;
use Kerox\Messenger\Model\Callback\MessageEcho;
use Kerox\Messenger\Model\Callback\Optin;
use Kerox\Messenger\Model\Callback\Postback;
use Kerox\Messenger\Model\Callback\Read;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class CallbackEventFactoryTest extends AbstractTestCase
{

    public function testRawEvent()
    {
        $raw = '{
          "sender":{
            "id":"USER_ID"
          },
          "recipient":{
            "id":"PAGE_ID"
          },
          "timestamp":1458692752478,
          "speech":{
            "mid":"mid.1457764197618:41d102a3e1ae206a38",
            "seq":73
          }
        }';

        $array = json_decode($raw, true);

        $expectedEvent = new RawEvent('USER_ID', 'PAGE_ID', ['timestamp' => 1458692752478, 'speech' => ['mid' => 'mid.1457764197618:41d102a3e1ae206a38', 'seq' => 73]]);
        $event = CallbackEventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testMessageEvent()
    {
        $raw = '{
          "sender":{
            "id":"USER_ID"
          },
          "recipient":{
            "id":"PAGE_ID"
          },
          "timestamp":1458692752478,
          "message":{
            "mid":"mid.1457764197618:41d102a3e1ae206a38",
            "seq":73,
            "text":"hello, world!",
            "quick_reply": {
              "payload": "DEVELOPER_DEFINED_PAYLOAD"
            }
          }
        }';

        $array = json_decode($raw, true);

        $expectedEvent = new MessageEvent('USER_ID', 'PAGE_ID', 1458692752478, Message::create($array['message']));
        $event = CallbackEventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testMessageEchoEvent()
    {
        $raw = '{
          "sender":{
            "id":"USER_ID"
          },
          "recipient":{
            "id":"PAGE_ID"
          },
          "timestamp":1457764197627,
          "message":{
            "is_echo":true,
            "app_id":1517776481860111,
            "metadata": "DEVELOPER_DEFINED_METADATA_STRING",
            "mid":"mid.1457764197618:41d102a3e1ae206a38",
            "seq":73,
            "text":"hello, world!",
            "quick_reply": {
              "payload": "DEVELOPER_DEFINED_PAYLOAD"
            }
          }
        }';

        $array = json_decode($raw, true);

        $expectedEvent = new MessageEchoEvent('USER_ID', 'PAGE_ID', 1457764197627, MessageEcho::create($array['message']));
        $event = CallbackEventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testPostbackEvent()
    {
        $raw = '{
          "sender":{
            "id":"USER_ID"
          },
          "recipient":{
            "id":"PAGE_ID"
          },
          "timestamp":1458692752478,
          "postback":{
            "payload": "USER_DEFINED_PAYLOAD",
            "referral": {
              "ref": "USER_DEFINED_REFERRAL_PARAM",
              "source": "SHORTLINK",
              "type": "OPEN_THREAD"
            }
          }
        }';

        $array = json_decode($raw, true);

        $expectedEvent = new PostbackEvent('USER_ID', 'PAGE_ID', 1458692752478, Postback::create($array['postback']));
        $event = CallbackEventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testOptinEvent()
    {
        $raw = '{
          "sender":{
            "id":"USER_ID"
          },
          "recipient":{
            "id":"PAGE_ID"
          },
          "timestamp":1234567890,
          "optin":{
            "ref":"PASS_THROUGH_PARAM"
          }
        }';

        $array = json_decode($raw, true);

        $expectedEvent = new OptinEvent('USER_ID', 'PAGE_ID', 1234567890, Optin::create($array['optin']));
        $event = CallbackEventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testAccountLinkingEvent()
    {
        $raw = '{
          "sender":{
            "id":"USER_ID"
          },
          "recipient":{
            "id":"PAGE_ID"
          },
          "timestamp":1234567890,
          "account_linking":{
            "status":"linked",
            "authorization_code":"PASS_THROUGH_AUTHORIZATION_CODE"
          }
        }';

        $array = json_decode($raw, true);

        $expectedEvent = new AccountLinkingEvent('USER_ID', 'PAGE_ID', 1234567890, AccountLinking::create($array['account_linking']));
        $event = CallbackEventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testDeliveryEvent()
    {
        $raw = '{
           "sender":{
              "id":"USER_ID"
           },
           "recipient":{
              "id":"PAGE_ID"
           },
           "delivery":{
              "mids":[
                 "mid.1458668856218:ed81099e15d3f4f233"
              ],
              "watermark":1458668856253,
              "seq":37
           }
        }';

        $array = json_decode($raw, true);

        $expectedEvent = new DeliveryEvent('USER_ID', 'PAGE_ID', Delivery::create($array['delivery']));
        $event = CallbackEventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }

    public function testReadEvent()
    {
        $raw = '{
           "sender":{
              "id":"USER_ID"
           },
           "recipient":{
              "id":"PAGE_ID"
           },
           "timestamp":1458668856463,
           "read":{
              "watermark":1458668856253,
              "seq":38
           }
        }';

        $array = json_decode($raw, true);

        $expectedEvent = new ReadEvent('USER_ID', 'PAGE_ID', 1458668856463, Read::create($array['read']));
        $event = CallbackEventFactory::create($array);

        $this->assertEquals($expectedEvent, $event);
    }
}