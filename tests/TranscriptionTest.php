<?php

namespace Tests;

use Laracasts\Transcriptions\Line;
use Laracasts\Transcriptions\Transcription;
use PHPUnit\Framework\TestCase;

class TranscriptionTest extends TestCase {
    function test_it_loads_a_vtt_file()
    {
        $path = __DIR__ . '/stubs/example.vtt';

        $transcription = Transcription::load($path);

        $this->assertStringContainsString('- Never drink liquid nitrogen.', $transcription);
        $this->assertStringContainsString('- It will perforate your stomach. You could die.', $transcription);
    }


    function test_it_can_convert_to_array_of_line_objects()
    {
        $path = __DIR__ . '/stubs/example.vtt';

        $lines = Transcription::load($path)->lines();

        $this->assertCount(2, $lines);
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    function test_it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $path = __DIR__ . '/stubs/example.vtt';

        $transcription = Transcription::load($path);

        $this->assertStringNotContainsString('WEBVTT', $transcription);
        $this->assertCount(2, $transcription->lines());
    }
}