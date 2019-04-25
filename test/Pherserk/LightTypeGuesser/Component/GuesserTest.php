<?php

namespace test\unit\Pherserk\LightTypeGuesser\Component;

use Pherserk\LightTypeGuesser\Component\Guesser;
use Pherserk\LightTypeGuesser\Component\MimeTypeHexSignatureDictionary;
use PHPUnit\Framework\TestCase;

use SplFileObject;

/**
 * @group unit
 */
class GuesserTest extends TestCase
{
    public function testGetMimeTypeFromFile()
    {
        $jpegFile = new SplFileObject(__DIR__ . '/../../../res/empty.jpg');
        $pngFile = new SplFileObject(__DIR__ . '/../../../res/empty.png');

        $dictionaryFile = new SplFileObject(__DIR__ . '/../../../res/dictionary.json');

        $guesser = new Guesser(MimeTypeHexSignatureDictionary::makeFromJsonFile($dictionaryFile));

        static::assertEquals('image/jpeg', $guesser->getMimeTypeFromFile($jpegFile));
        static::assertEquals('application/octet-stream', $guesser->getMimeTypeFromFile($pngFile));
    }
}
