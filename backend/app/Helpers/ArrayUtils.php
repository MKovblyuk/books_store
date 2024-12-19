<?php

namespace App\Helpers;

class ArrayUtils
{
    /**
     * @return string sorted in format k1_v1_v2_k2_v1 ..
     */
    public static function sortByKeysAndValues(array $arr, string $delimiter = '_'): string
    {
        $res = '';
        $keys = array_keys($arr);
        sort($keys);

        foreach ($keys as $key) {
            if (is_array($arr[$key])) {
                $res .= $delimiter . $key . self::sortByKeysAndValues($arr[$key], $delimiter);
            } else {
                $values = explode(',', $arr[$key]);
                sort($values);
                $res .= $delimiter . $key . $delimiter . implode($delimiter, $values);
            }
        }

        return $res;
    }
}