<?php

namespace App\Model;

/**
 * Merge arrays. If an argument is null, ignore it
 *
 * @param array|null ...$arrays
 * @return array
 */
function mergeArrays(?array ...$arrays): array
{
    $result = [];
    foreach ($arrays as $array) {
        if ($array !== null) {
            $result = array_merge($result, $array);
        }
    }
    return $result;
}
