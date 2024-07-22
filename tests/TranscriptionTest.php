<?php

namespace Tests;

use Laracasts\Transcriptions\Line;
use Laracasts\Transcriptions\Transcription;
use PHPUnit\Framework\TestCase;

class TranscriptionTest extends TestCase {
    function test_it_loads_a_vtt_file()
    {
        $transcription = Transcription::load(__DIR__ . '/stubs/example.vtt');

        $this->assertStringContainsString('- Never drink liquid nitrogen.', $transcription);
        $this->assertStringContainsString('- It will perforate your stomach. You could die.', $transcription);
    }


    function test_it_can_convert_to_array_of_line_objects()
    {
        $lines = Transcription::load(__DIR__ . '/stubs/example.vtt')->lines();

        $this->assertCount(2, $lines);
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    function test_it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $transcription = Transcription::load(__DIR__ . '/stubs/example.vtt');

        $this->assertStringNotContainsString('WEBVTT', $transcription);
        $this->assertCount(2, $transcription->lines());
    }

    /** @test **/
    function test_it_renders_the_lines_as_html() {
        $transcription = Transcription::load(__DIR__ . '/stubs/example.vtt');

        $expected = <<< EOT
        <a href="?time=00:03">- Never drink liquid nitrogen.</a>
        <a href="?time=00:04">- It will perforate your stomach. You could die.</a>
        EOT;

        $htmlLines = $transcription->htmlLines();

        $this->assertEquals($expected, $htmlLines);
    }
}