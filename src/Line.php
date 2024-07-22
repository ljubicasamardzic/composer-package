<?php


namespace Laracasts\Transcriptions;


class Line
{

    public string $timestamp;
    public string $body;

    public function __construct(string $timestamp, string $body)
    {
        $this->timestamp = $timestamp;
        $this->body = $body;
    }

    public static function valid($line): bool
    {
        return $line != 'WEBVTT' && $line !='';
    }

    public function beginningTimestamp()
    {
        preg_match('/^\d{2}:(\d{2}:\d{2})\.\d{3}/', $this->timestamp, $matches);

        return $matches[1];
    }

    public function toAnchorTag(): String
    {

        return "<a href=\"?time={$this->beginningTimestamp()}\">{$this->body}</a>";
    }

}