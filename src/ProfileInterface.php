<?php

declare(strict_types=1);

namespace Kerox\Messenger;

interface ProfileInterface
{
    public const GET_STARTED = 'get_started';
    public const GREETING = 'greeting';
    public const ICE_BREAKERS = 'ice_breakers';
    public const PERSISTENT_MENU = 'persistent_menu';
    public const DOMAIN_WHITELISTING = 'whitelisted_domains';
    public const ACCOUNT_LINKING_URL = 'account_linking_url';
    public const PAYMENT_SETTINGS = 'payment_settings';
    public const HOME_URL = 'home_url';
    public const TARGET_AUDIENCE = 'target_audience';
}
