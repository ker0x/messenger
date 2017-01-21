[![Build](https://img.shields.io/travis/ker0x/messenger.svg?style=flat-square)](https://travis-ci.org/ker0x/messenger)
[![Coverage](https://img.shields.io/scrutinizer/coverage/g/ker0x/messenger.svg?style=flat-square)](https://scrutinizer-ci.com/g/ker0x/messenger/)
[![Code Quality](https://img.shields.io/scrutinizer/g/ker0x/messenger.svg?style=flat-square)](https://scrutinizer-ci.com/g/ker0x/messenger/)
[![Total Downloads](https://img.shields.io/packagist/dt/kerox/messenger.svg?style=flat-square)](https://packagist.org/packages/kerox/messenger)
[![Latest Stable Version](https://img.shields.io/packagist/v/kerox/messenger.svg?style=flat-square)](https://packagist.org/packages/kerox/messenger)
[![License](https://img.shields.io/packagist/l/kerox/messenger.svg?style=flat-square)](https://packagist.org/packages/kerox/messenger)

# PHP Library for Facebook Messenger

A PHP libray to send message and configure thread to [Facebook Messenger](https://www.messenger.com/)

## Requirements

* PHP >= 7.0

## Installation

To install this plugin, run `composer require kerox/messenger` or add this snippet in your project’s composer.json.

```json
"require": {
    "kerox/messenger": "~1.0"
}
```

## Usage

First, you have to create a Messenger instance

```php
use Kerox\Messenger\Messenger;

$messenger = new Messenger($appSecret, $verifyToken, $pageToken)
```

### Webhook API

To be able to send messages to an user, you need to configure a webhook in your Facebook application. To do that, follow the instructions [here](https://developers.facebook.com/docs/messenger-platform/guides/setup). 

Once your webhook is configured, you need to validate the callback URL

```php
if (!$messenger->webhook()->isValidToken()) {
    // Display an error
}

$challenge = $messenger->webhook()->getChallenge();

header("HTTP/1.1 200 OK");
echo $challenge;
```

Then you will be able to handle callbacks from messenger
 
```php
if (!$messenger->webhook()->isValidCallback()) {
    header("HTTP/1.1 400 Invalid Request");
}

$events = $messenger->webhook()->getCallbackEvents();
foreach ($events as $event) {
    if ($event instance of MessageEvent) {
        $message = $event->getMessage();
        
        echo $message->getMessageId();
        echo $message->getSequence();
        
        if ($message->hasText()) {
            echo $message->getText();
        }
        
        if ($message->hasQuickReply()) {
            echo $message->getQuickReply();
        }
        
        if ($message->hasAttachments()) {
            print_r($message->getAttachments());
        }
    }
    
    if ($event instance PostbackEvent) {
        $postback = $event->getPostback();
        
        echo $postback->getPayload();
    }
}

header("HTTP/1.1 200 OK")
``` 

### Send API

#### Send a simple message:

```php
$messenger->send()->sendMessage(<USER_ID>, 'Hello world!');
```

#### Send a message with quick replies:

```php
use Kerox\Messenger\Model\Message;
use Kerox\Messenger\Model\Message\QuickReply;

$message = new Message('Pick a color:');
$message
    ->setQuickReplies([
        (new QuickReply('text'))
            ->setTitle('Red')
            ->setPayload('DEVELOPER_DEFINED_PAYLOAD_FOR_PICKING_RED')
            ->setImageUrl('http://petersfantastichats.com/img/red.png'),
        (new QuickReply('text'))
            ->setTitle('Green')
            ->setPayload('DEVELOPER_DEFINED_PAYLOAD_FOR_PICKING_GREEN')
            ->setImageUrl('http://petersfantastichats.com/img/green.png')
    ])
    ->addQuickReply(new QuickReply('location'))
    ->setMetadata('some metadata');
    
$messenger->send()->sendMessage(<USER_ID>, $message);
```

#### Send a message with a receipt

```php
use Kerox\Messenger\Model\Common\Address;
use Kerox\Messenger\Model\Message\Attachment\Template\Element\ReceiptElement;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Adjustment;
use Kerox\Messenger\Model\Message\Attachment\Template\Receipt\Summary;

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
            
$messenger->send()->sendMessage(<USER_ID>, $receipt);
```

### Thread API

#### Set a greeting message

```php
use Kerox\Messenger\Model\ThreadSettings\Greeting;

$greeting = new Greeting('Timeless apparel for the masses.');

$messenger->thread()->addSetting($greeting);
```

#### Set a start button

```php
use Kerox\Messenger\Model\ThreadSettings\StartButton;

$startButton = new StartButton('USER_DEFINED_PAYLOAD');

$messenger->thread()->addSetting($startButton);
```

#### Set a persistent menu

```php
use Kerox\Messenger\Model\Common\Buttons\Postback;
use Kerox\Messenger\Model\Common\Buttons\WebUrl;
use Kerox\Messenger\Model\ThreadSettings\Menu;

$menu = new Menu([
    new Postback('Help', 'DEVELOPER_DEFINED_PAYLOAD_FOR_HELP'),
    new Postback('Start a New Order', 'DEVELOPER_DEFINED_PAYLOAD_FOR_START_ORDER'),
    (new WebUrl('Checkout', 'http://petersapparel.parseapp.com/checkout'))->setWebviewHeightRatio(WebUrl::RATIO_TYPE_FULL)->setMessengerExtension(true),
    new WebUrl('View Website', 'http://petersapparel.parseapp.com/'),
]);

$messenger->thread()->addSetting($menu);
```

#### Remove a setting

```php
$messenger->thread()->deleteSetting('call_to_actions', 'existing_thread');
```

### User API

To retrieve user's informations

```php
$user = $messenger->user()->getProfile(<sender_id>);

$user->getFirstname();
$user->getLastname();
$user->getProfilePic();
$user->getLocale();
$user->getTimezone();
$user->getGender();
$user->getIsPaymentEnabled();
```

## License

MIT License

Copyright (c) 2016 Romain Monteil

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.