# LightTypeGuesser

## Usage

The library can handle files on file system or base64 encoded files strings.

A dictionary must be provided in json format, eg:

```json
[
  {"signature": "FFD8FFE0", "mimeType": "image/jpeg"}
]
```

Example usage:

```php
<?php

use Pherserk\LightTypeGuesser\Component\Guesser;
use Pherserk\LightTypeGuesser\Component\MimeTypeHexSignatureDictionary;

// A dictionary file must be provided
$dictionaryFile = new SplFileObject('path/to/some-dictionary.json');

// Instantiate the guesser
$guesser = new Guesser(MimeTypeHexSignatureDictionary::makeFromJsonFile($file));

// The file must be passed as a SplFileObject
$file = new SplFileObject('path/to/some-file.txt');

// Guess the mime type
$mimeType = $guesser->getMimeTypeFromFile($file);

// Alternatively the base64 content of the file can be passed
$base64FileContent = 'Zm9vYmFy';

// And guessed (note string is passed by reference but not altered, this to avoid memory consumption)
$mimeType = $guesser->getMimeTypeFromBase64($base64FileContent);
```
