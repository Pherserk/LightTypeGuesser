<?php

declare(strict_types=1);

namespace test\unit\Pherserk\LightTypeGuesser\Component;

use Pherserk\LightTypeGuesser\Component\MimeTypeHexSignatureDictionary;
use PHPUnit\Framework\TestCase;
use SplFileObject;

/**
 * @group unit
 */
class MimeTypeHexSignatureDictionaryTest extends TestCase
{
    public function testMakeFromJsonFile()
    {
        $file = new SplFileObject(__DIR__ . '/../../../res/dictionary.json');
        $dictionary = MimeTypeHexSignatureDictionary::makeFromJsonFile($file);

        static::assertEquals(10, $dictionary->getMaxSignatureLength());
        static::assertEquals('foo-bar/baz', $dictionary->get('AA'));
    }
}
