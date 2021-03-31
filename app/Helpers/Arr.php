<?php

namespace App\Helpers;

use Illuminate\Support\Arr as LaravelArr;

final class Arr extends LaravelArr
{
    public static function nestedLowercase(array|string $array): array|string
    {
        if (is_array($array)) {
            return array_map([
                self::class,
                'nestedLowercase',
            ], $array);
        }
        return strtolower($array);
    }

    public static function nestedArrToLowerCase(array &$array): void
    {
        $array = array_map([self::class, 'nestedLowercase'], $array);
    }

    private static function prepareArrayToCaseInsensitiveCompare(array &$array):void {
        sort($array);
        self::nestedArrToLowerCase($array);
    }

    public static function compareCaseInsensitive(...$arrays): bool
    {
        $auxiliaryArray = array_shift($arrays);
        self::prepareArrayToCaseInsensitiveCompare($auxiliaryArray);

        foreach ($arrays as $key => $array) {
            self::prepareArrayToCaseInsensitiveCompare($array);

            //One difference is enough to return the value
            if($array !== $auxiliaryArray) {
                return false;
            }
        }

        return true;
    }

}
