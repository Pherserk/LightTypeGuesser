<?php

declare(strict_types=1);

namespace Pherserk\LightTypeGuesser\Component;

use SplFileObject;

class Guesser
{
    const DEFAULT_MIME = 'application/octet-stream';

    private $initialSignatureLength;
    private $mimeTypeHexSignatureDictionary = [];

    public function __construct(MimeTypeHexSignatureDictionary $mimeTypeHexSignatureDictionary)
    {
        $this->mimeTypeHexSignatureDictionary = $mimeTypeHexSignatureDictionary;
        $this->initialSignatureLength = $mimeTypeHexSignatureDictionary->getMaxSignatureLength();
    }

    public function getMimeTypeFromFile(SplFileObject $file): string
    {
        $signature = $file->fread($this->initialSignatureLength);

        return $this->getMimeTypeFromRawSignature($signature);
    }

    public function getMimeTypeFromBase64(string & $content): string
    {
        $signature = base64_decode(
            mb_substr(
                $content,
                0,
                Base64OutputLengthCalculator::forecastFromBinaryInputLength($this->initialSignatureLength)
            )
        );

        return $this->getMimeTypeFromRawSignature($signature);
    }

    private function getMimeTypeFromRawSignature(string $rawSignature): string
    {
        $hexSignature = strtoupper(current(unpack('H*', $rawSignature)));

        do {
            if ($detectedMime = $this->mimeTypeHexSignatureDictionary->get($hexSignature) ?? null) {
                return $detectedMime;
            }

            $hexSignature = mb_substr($hexSignature, 0, -1);
        } while(strlen($hexSignature));

        return static::DEFAULT_MIME;
    }
}
