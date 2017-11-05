<?php

namespace Kerox\Messenger;

interface ProfileInterface
{
    public const PERSISTENT_MENU = 'persistent_menu';
    public const GET_STARTED = 'get_started';
    public const GREETING = 'greeting';
    public const DOMAIN_WHITELISTING = 'whitelisted_domains';
    public const ACCOUNT_LINKING_URL = 'account_linking_url';
    public const PAYMENT_SETTINGS = 'payment_settings';
    public const TARGET_AUDIENCE = 'target_audience';
}
