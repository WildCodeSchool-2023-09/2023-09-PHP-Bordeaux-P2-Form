<?php

namespace App\Model;

class FunctionManager
{
    public static function isColor(string $color): bool
    {
        $ref = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F'];
        $maj = strtoupper($color);
        if (strlen($maj) === 7 && $maj[0] === '#') {
            for ($i = 1; $i < strlen($color); $i++) {
                if (!in_array($maj[$i], $ref)) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }
}
