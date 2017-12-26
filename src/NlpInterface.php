<?php

declare(strict_types=1);

namespace Kerox\Messenger;

interface NlpInterface
{
    public const CONFIG_KEY_NLP_ENABLED = 'nlp_enabled';
    public const CONFIG_KEY_MODEL = 'model';
    public const CONFIG_KEY_CUSTOM_TOKEN = 'custom_token';
    public const CONFIG_KEY_VERBOSE = 'verbose';
    public const CONFIG_KEY_N_BEST = 'n_best';

    public const MODEL_CUSTOM = 'custom';
    public const MODEL_DEFAULT_ARABIC = 'ar';
    public const MODEL_DEFAULT_CHINESE = 'zh';
    public const MODEL_DEFAULT_CROATIAN = 'hr';
    public const MODEL_DEFAULT_DANISH = 'da';
    public const MODEL_DEFAULT_DUTCH = 'nl';
    public const MODEL_DEFAULT_ENGLISH = 'en';
    public const MODEL_DEFAULT_FRENCH = 'fr';
    public const MODEL_DEFAULT_GERMAN = 'de';
    public const MODEL_DEFAULT_GREEK = 'el';
    public const MODEL_DEFAULT_HEBREW = 'he';
    public const MODEL_DEFAULT_HUNGARIAN = 'hu';
    public const MODEL_DEFAULT_IRISH = 'ga';
    public const MODEL_DEFAULT_ITALIAN = 'it';
    public const MODEL_DEFAULT_KOREAN = 'ko';
    public const MODEL_DEFAULT_NORWEGIAN = 'nb';
    public const MODEL_DEFAULT_POLISH = 'pl';
    public const MODEL_DEFAULT_PORTUGESE = 'pt';
    public const MODEL_DEFAULT_ROMANIAN = 'ro';
    public const MODEL_DEFAULT_SPANISH = 'es';
    public const MODEL_DEFAULT_VIETNAMESE = 'vi';
}
