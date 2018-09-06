# CHANGELOG

The Messenger library follows [SemVer](http://semver.org/).

## 3.x

Version 3 of the Messenger library is an enhancement of version 2 with major break changes.

- 3.0.0 (2018-08-)
    - Update API version to `v3.1`.
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
    - Increase limit to 640 characters for `$text` in `\Kerox\Messenger\Model\Message\Attachment\Template\ButtonTemplate()`. (Thanks to @mferrara)
    - Improve tests
    - Refactor code
