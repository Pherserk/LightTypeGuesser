<?php

namespace test\unit\Pherserk\LightTypeGuesser\Component;

use Pherserk\LightTypeGuesser\Component\Base64OutputLengthCalculator;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class Base64OutputLengthCalculatorTest  extends TestCase
{
    /**
     * @dataProvider provideInput
     */
    public function testForecastFromBinaryInputLength(string $input)
    {
        static::assertEquals(
            strlen(base64_encode($input)),
            Base64OutputLengthCalculator::forecastFromBinaryInputLength(strlen($input))
        );
    }

    public function provideInput()
    {
        return [
            ['',],
            [' ',],
            ['foo.bar.baz',],
            ["‡• ‥※ acme É opo*o \"?34 あ  ⁂⸎ ┚┚┚ ☘☘☘   ☎ \n  ☔☔☔ ☠☠ ☣☣☣ \nああ",],
        ];
    }
}