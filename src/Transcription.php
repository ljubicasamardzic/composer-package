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
        return implode("", $this->lines);
    }

    public function lines(): array
    {
        $results = [];

        for ($i = 0; $i < count($this->lines); $i+=2) {
            $results[] = new Line($this->lines[$i], $this->lines[$i+1]);
        }

        return $results;
    }

    protected function discardInvalidLines(array $lines): array
    {
        return array_values(array_filter(
            $lines,
            fn ($line) => Line::valid($line)
        ));
    }

}