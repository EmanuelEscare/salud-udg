<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self 1()
 * @method static self 2()
 * @method static self 3()
 */
final class Semester extends Enum
{
    protected static function labels(): array
    {
        return [
            '1' => '1 - 3',
            '2' => '4 - 6',
            '3' => '7+',
        ];
    }
}
