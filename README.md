[![Tests](https://img.shields.io/github/actions/workflow/status/ker0x/messenger/ci.yml?label=tests&style=for-the-badge)](https://github.com/ker0x/fcm/actions/workflows/ci.yml)
[![Coverage](https://img.shields.io/codecov/c/gh/ker0x/messenger?style=for-the-badge)](https://codecov.io/gh/ker0x/messenger/)
![PHP Version](https://img.shields.io/badge/php->=7.3-4f5b93.svg?style=for-the-badge)
[![Download](https://img.shields.io/packagist/dt/kerox/messenger.svg?style=for-the-badge)](https://packagist.org/packages/kerox/messenger)
[![Packagist](https://img.shields.io/packagist/v/kerox/messenger.svg?style=for-the-badge)](https://packagist.org/packages/kerox/messenger)
[![License](https://img.shields.io/packagist/l/kerox/messenger.svg?style=for-the-badge)](https://github.com/ker0x/messenger/blob/main/LICENSE)

# Messenger

A PHP library to interact with [Facebook Messenger Platform](https://www.messenger.com/)

## Installation

You can install Messenger using Composer:

```
composer require kerox/messenger
```

You will then need to:
* run ``composer install`` to get these dependencies added to your vendor directory
* add the autoloader to your application with this line: ``require('vendor/autoload.php');``

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

- [x] Broadcast (deprecated)
- [x] Code (deprecated)
- [x] Insights
- [x] Nlp
- [x] Persona
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
    - [x] Nested (deprecated)
    - [x] Payment
    - [x] Phone Number
    - [x] Postback
    - [x] Share (deprecated)
    - [x] Web Url
- [x] Generic
- [x] List (deprecated)
- [x] Media
- [x] Receipt

### Callback

- [x] Account Linking
- [x] AppRoles
- [x] Checkout Update
- [x] Delivery
- [x] GamePlay
- [x] Message
- [x] Message Echo
- [x] Optin
- [x] PassThreadControl
- [x] Payment
- [x] Policy Enforcement
- [x] Postback
- [x] Pre Checkout
- [x] Read
- [x] Reaction
- [x] Referral
- [x] RequestThreadControl
- [x] TakeThreadControl
