<?php

namespace Laracasts\Transcriptions;

class Transcription
{
    protected array $lines;

    /**
     * Transcription constructor.
     * @param array $lines
     */
    public function __construct(array $lines)
    {
        $this->lines = $this->discardInvalidLines(array_map('trim', $lines));
    }

    public static function load (string $path): self
    {
        $lines = file($path);

        return new static($lines);
    }

    public function __toString()
    {
        return implode("\n", $this->lines);
    }

    public function lines(): array
    {
       $lines = array_chunk($this->lines, 2);

        return array_map(function ($line) {
            return new Line($line[0], $line[1]);
        }, $lines);
    }

    public function htmlLines()
    {
        return implode("\n", array_map(
            fn(Line $line) => $line->toAnchorTag(),
            $this->lines()
        ));
    }

    protected function discardInvalidLines(array $lines): array
    {
        return array_values(array_filter(
            $lines,
            fn ($line) => Line::valid($line)
        ));
    }

}