<?php

declare(strict_types=1);

namespace Pherserk\LightTypeGuesser\Component;

class Base64OutputLengthCalculator
{
    public static function forecastFromBinaryInputLength(int $binaryInputLength): int
    {
        return (int) (4 * ceil(((double) $binaryInputLength / 3)));
    }
}