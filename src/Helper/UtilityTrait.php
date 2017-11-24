<?php

declare(strict_types=1);

namespace Kerox\Messenger\Helper;

trait UtilityTrait
{
    /**
     * Enhanced version of array_filter which allow to filter recursively.
     *
     * @param array          $array
     * @param callable|array $callback
     *
     * @return array
     */
    public function arrayFilter(array $array, $callback = ['self', 'filter']): array
    {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $array[$k] = $this->arrayFilter($v, $callback);
            }
        }

        return array_filter($array, $callback);
    }

    /**
     * Callback function for filtering.
     *
     * @param mixed $var array to filter
     *
     * @return bool
     */
    protected static function filter($var): bool
    {
        return $var === 0 || $var === 0.0 || $var === '0' || !empty($var);
    }
}
