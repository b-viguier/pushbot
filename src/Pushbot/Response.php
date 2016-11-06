<?php

namespace M6\Pushbot;

class Response
{
    const SUCCESS = 'success';
    const FAILURE = 'failure';

    public $status;
    public $body;

    public function __construct(string $status, string $body = '')
    {
        $this->status = $status;
        $this->body = $body;
    }

    public function __get($name)
    {
        throw new \Exception("Unknown attribute '$name");
    }
}
