<?php

namespace Tests;

use Laracasts\Transcriptions\Line;
use Laracasts\Transcriptions\Transcription;
use PHPUnit\Framework\TestCase;

class TranscriptionTest extends TestCase {

    protected $transcription;

    protected function setUp(): void
    {
        $this->transcription = Transcription::load(__DIR__ . '/stubs/example.vtt');
    }


    function test_it_loads_a_vtt_file()
    {
        $this->assertStringContainsString('- Never drink liquid nitrogen.', $this->transcription);
        $this->assertStringContainsString('- It will perforate your stomach. You could die.', $this->transcription);
    }


    function test_it_can_convert_to_array_of_line_objects()
    {
        $lines = $this->transcription->lines();

        $this->assertCount(2, $lines);
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    function test_it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $this->assertStringNotContainsString('WEBVTT', $this->transcription);
        $this->assertCount(2, $this->transcription->lines());
    }

    /** @test **/
    function test_it_renders_the_lines_as_html() {
        $expected = <<< EOT
            <a href="?time=00:03">- Never drink liquid nitrogen.</a>
            <a href="?time=00:04">- It will perforate your stomach. You could die.</a>
            EOT;

        $htmlLines = $this->transcription->htmlLines();

        $this->assertEquals($expected, $htmlLines);
    }
}