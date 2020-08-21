# CHANGELOG

The Messenger library follows [SemVer](http://semver.org/).

## 3.x

**Changelog** (since [`3.3.2`](https://github.com/ker0x/messenger/compare/3.3.2...3.3.3))

- 3.3.3 (2020-08)
    - Change maximum value for quick replies. (Thanks to @nferbey)
    - Add nlp traits and detected locales to callback message. (Thanks to @htaoufikallah)
    - Update Travis and Scrutinizer configuration

**Changelog** (since [`3.3.1`](https://github.com/ker0x/messenger/compare/3.3.1...3.3.2))

- 3.3.2 (2020-02)
    - Allow to pass an array as recipient to send message
    - Rename all `testBad*` methods to `testInvalid*` 

**Changelog** (since [`3.3.0`](https://github.com/ker0x/messenger/compare/3.3.0...3.3.1))

- 3.3.1 (2020-01)
    - Add PHP 7.4 to Travis
    - Add Support of `CONFIRMED_EVENT_UPDATE` and `POST_PURCHASE_UPDATE` message tags. (Thanks to @BFoucher)
    - Deprecated old message tags which will be disabled on March 4th, 2020 (see [Current Supported Tags](https://developers.facebook.com/docs/messenger-platform/send-messages/message-tags#current_supported_tags))
    - Buttons type `element_share` and `nested` are now deprecated

**Changelog** (since [`3.2.0`](https://github.com/ker0x/messenger/compare/3.2.0...3.3.0))

- 3.3.0 (2019-11)
    - Update API version to `v5.0`
    - Add Support of `image_aspect_ratio` property for Generic Template (Thanks to @BFoucher)
    - Add support of `ice_breakers` and `home_url` properties for Profile API
    - Add support of `reply_to` property for Message callback
    - Add support of `Reaction` event
    - Properties `payment_settings` and `target_audience` are now deprecated
    
**Changelog** (since [`3.1.1`](https://github.com/ker0x/messenger/compare/3.1.1...3.2.0))

- 3.2.0 (2019-08)
    - Update API version to `v3.3`
    - Remove parameter `seq` from webhook Events (Thanks to @SoleneLms)
    - Api Broadcast and Code are now deprecated (see [CHANGELOG](https://developers.facebook.com/docs/messenger-platform/changelog))
    - Template List and Open Graph are now deprecated (see [CHANGELOG](https://developers.facebook.com/docs/messenger-platform/changelog))
    - Button Share, Nested and Location for Quickreply are now deprecated (see [CHANGELOG](https://developers.facebook.com/docs/messenger-platform/changelog))
    - Add PHPStan for tests

**Changelog** (since [`3.1.0`](https://github.com/ker0x/messenger/compare/3.1.0...3.1.1))

- 3.1.1 (2018-12)
    - Method `addQuickReply` will no longer thrown an exception if no quick replies were previously set (Thanks to @Khodl)
    - Add new tests for QuickReplies
    - Update `phpunit/phpunit` version to `7.4`.
    - Remove `squizlabs/php_codesniffer` as a require-dev dependencies.

**Changelog** (since [`3.0.0`](https://github.com/ker0x/messenger/compare/3.0.0...3.1.0))

- 3.1.0 (2018-10)
    - Update API version to `v3.2`.
    - Fix type for properties *AppId in `\Kerox\Messenger\Model\Callback\PassThreadControl::class`, `\Kerox\Messenger\Model\Callback\RequestThreadControl::class` and `\Kerox\Messenger\Model\Callback\TakeThreadControl::class`. (Thanks to @dbknet)
    - Change method visibility from `public` to `protected` in `\Kerox\Messenger\Helper\ValidatorTrait::class`
    - Remove methods `isPaymentEnabled` and `getLastAdReferral` from `\Kerox\Messenger\Response\UserResponse::class` as there are been removed from the API (see [CHANGELOG](https://developers.facebook.com/docs/graph-api/changelog/version3.1#messenger-platform))

**Changelog** (since [`2.1.1`](https://github.com/ker0x/messenger/compare/2.1.1...3.0.0))

Version `3.0.0` of the Messenger library is an enhancement of version `2.1.1` with major break changes.

- 3.0.0 (2018-10)
    - Update API version to `v3.1`.
    - Add support for Persona API (Thanks to @misantron).
    - Add support for the BUSINESS_PRODUCTIVITY message tag (Thanks to @atgg).
    - Adding `$appVersion` as optional 4th argument in `\Kerox\Messenger\Messenger::__construct()` with default value to const `API_VERSION`.
    - Remove parameters `$notificationType` and `$tag` for methods `message()` and `action` in `\Kerox\Messenger\Api\Send()`.
    - Remove parameters `$notificationType` and `$tag` for methods `send()` in `\Kerox\Messenger\Api\Broadcast()`.
    - Add parameter `$options` for methods `message()` and `action` in `\Kerox\Messenger\Api\Send()`.
    - Add parameter `$options` for methods `send()` in `\Kerox\Messenger\Api\Broadcast()`.
    - Remove parameters `$notificationType`, `$tag` and `$messagingType` for method `__construct()` in `\Kerox\Messenger\Request\SendRequest()`.
    - Remove parameters `$notificationType`, `$tag` for method `__construct()` in `\Kerox\Messenger\Request\BroadcastRequest()`.
    - Add parameter `$options` for method `__construct()` in `\Kerox\Messenger\Request\SendRequest()`.
    - Add parameter `$options` for method `__construct()` in `\Kerox\Messenger\Request\BroadcastRequest()`.
    - Move constants `MESSAGING_TYPE_RESPONSE`, `MESSAGING_TYPE_UPDATE`, `MESSAGING_TYPE_MESSAGE_TAG` and `MESSAGING_TYPE_NON_PROMOTIONAL_SUBSCRIPTION` from `\Kerox\Messenger\Request\SendRequest()` to `\Kerox\Messenger\SendInterface`
    - Method `addQuickReply()` in `\Kerox\Messenger\Model\Message()` will throw an exception if there is already too many quick replies.
    - Parameters `$ref`, `$source` and `$type` in `\Kerox\Messenger\Model\Callback\Referral()` can now return `null`.
    - Add parameter `$sharable` in `\Kerox\Messenger\Model\Message\Attachment\Template\ButtonTemplate()`.
    - Increase limit to 640 characters for `$text` in `\Kerox\Messenger\Model\Message\Attachment\Template\ButtonTemplate()`. (Thanks to @mferrara).
    - Throw new Exception for better information.
    - Improve tests.
    - Refactor code.
