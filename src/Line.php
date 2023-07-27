<?php


namespace Laracasts\Transcriptions;


class Line
{

    protected string $timestamp;
    protected string $body;

    public function __construct(string $timestamp, string $body)
    {
        $this->timestamp = $timestamp;
        $this->body = $body;
    }

    public static function valid($line): bool
    {
        return $line != 'WEBVTT' && $line !='';
    }

}