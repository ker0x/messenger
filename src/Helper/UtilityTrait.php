<?php
namespace Kerox\Messenger\Helper;

trait UtilityTrait
{

    /**
     * Returns the input lower_case_delimited_string as a CamelCasedString.
     *
     * @param string $string String to be camelize
     * @param string $delimiter The delimiter in the input string
     * @return string
     */
    public static function camelize(string $string, string $delimiter = '_'): string
    {
        return implode('', array_map('ucfirst', array_map('strtolower', explode($delimiter, $string))));
    }
}
