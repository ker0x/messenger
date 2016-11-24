<?php
namespace Kerox\Messenger\Helper;

class XHubSignatureHelper
{

    /**
     * @param string $content
     * @param string $secret
     * @param string $signature
     * @return bool
     */
    public static function validate(string $content, string $secret, string $signature): bool
    {
        list($algorithm, $hash) = explode('=', $signature);

        return hash_equals(self::compute($algorithm, $content, $secret), $hash);
    }

    /**
     * @param string $algorithm
     * @param string $content
     * @param string $secret
     * @return string
     */
    public static function compute(string $algorithm, string $content, string $secret): string
    {
        return hash_hmac($algorithm, $content, $secret);
    }
}
