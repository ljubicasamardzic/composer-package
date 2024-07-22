<?php

use Laracasts\Transcriptions\Transcription;

require '../vendor/autoload.php';

$path = __DIR__.'/../tests/stubs/example.vtt';

var_dump(Transcription::load($path)->htmlLines());