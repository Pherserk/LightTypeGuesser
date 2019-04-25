<?php

declare(strict_types=1);

namespace Pherserk\LightTypeGuesser\Component;

use RuntimeException;
use SplFileObject;

class MimeTypeHexSignatureDictionary
{
    private const MIME_TYPE_REGEX = '/^[-\w\+\.]+\/[-\w\+\.]+(;[a-z]+=[-\w\+\.]+)?$/';

    private $dictionary = [];

    private $maxSignatureLength = 0;

    public function __construct(array $dictionary)
    {
        foreach ($dictionary as $signature => $mimeType) {
            if (!ctype_xdigit($signature)) {
                throw new RuntimeException("'{$signature}' is not a valid signature: not an hex value");
            }

            if (!preg_match(static::MIME_TYPE_REGEX, $mimeType)) {
                throw new RuntimeException("'{$mimeType}' is not a valid mime type: wrong format");
            }

            $this->maxSignatureLength = max($this->maxSignatureLength, strlen($signature));
        }

        $this->dictionary = $dictionary;
    }

    public static function makeFromJsonFile(SplFileObject $dictionaryFile): self
    {
        $dictionary = [];
        foreach (json_decode(file_get_contents($dictionaryFile->getRealPath())) as $entry) {
            $dictionary[$entry->signature] = $entry->mimeType;
        }

        return new self($dictionary);

    }

    public function get(string $hexSignature): ? string
    {
        return $this->dictionary[$hexSignature];
    }

    public function getMaxSignatureLength(): int
    {
        return $this->maxSignatureLength;
    }
}