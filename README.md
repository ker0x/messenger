|Travis|Coverage|Code Quality|PHP|Downloads|Stable Version|License|Gitter|
|:------:|:-------:|:-------:|:-------:|:-------:|:-------:|:-------:|:-------:|
|[![Build](https://img.shields.io/travis/ker0x/messenger.svg?style=flat-square)](https://travis-ci.org/ker0x/messenger)|[![Coverage](https://img.shields.io/scrutinizer/coverage/g/ker0x/messenger.svg?style=flat-square)](https://scrutinizer-ci.com/g/ker0x/messenger/)|[![Code Quality](https://img.shields.io/scrutinizer/g/ker0x/messenger.svg?style=flat-square)](https://scrutinizer-ci.com/g/ker0x/messenger/)|[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg?style=flat-square)](https://php.net)|[![Total Downloads](https://img.shields.io/packagist/dt/kerox/messenger.svg?style=flat-square)](https://packagist.org/packages/kerox/messenger)|[![Latest Stable Version](https://img.shields.io/packagist/v/kerox/messenger.svg?style=flat-square)](https://packagist.org/packages/kerox/messenger)|[![License](https://img.shields.io/packagist/l/kerox/messenger.svg?style=flat-square)](https://packagist.org/packages/kerox/messenger)|[![Gitter](https://img.shields.io/badge/chat-gitter-46bc99.svg?style=flat-square)](https://gitter.im/ker0x/messenger?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

# Messenger

A PHP library to interact with [Facebook Messenger Platform](https://www.messenger.com/)

## Installation

To install this library, simply run `composer require kerox/messenger`

## Basic usage

```php
use Kerox\Messenger\Messenger;

$messenger = new Messenger($appSecret, $verifyToken, $pageToken)
$messenger->send()->message(<USER_ID>, 'Hello world!');
```

## Advance usage

Please, refer to the [wiki](https://github.com/ker0x/messenger/wiki) to learn how to use this library

## Features

### API

- [x] Broadcast
- [x] Code
- [x] Insights
- [x] Nlp
- [x] Profile
- [x] Send
- [x] Tag
- [x] Thread
- [x] User
- [x] Webhook

### Templates

- [x] Airline Boarding Pass
- [x] Airline Check In
- [x] Airline Itinerary
- [x] Airline Update
- [x] Buttons
    - [x] Account Link
    - [x] Account Unlink
    - [x] Nested
    - [x] Payment
    - [x] Phone Number
    - [x] Postback
    - [x] Share
    - [x] Web Url
- [x] Generic
- [x] List
- [x] Media
- [x] Receipt

### Callback

- [x] Account Linking
- [x] AppRoles
- [x] Checkout Update
- [x] Delivery
- [x] Message
- [x] Message Echo
- [x] Optin
- [x] PassThreadControl
- [x] Payment
- [x] Policy Enforcement
- [x] Postback
- [x] Pre Checkout
- [x] Read
- [x] Referral
- [x] TakeThreadControl
