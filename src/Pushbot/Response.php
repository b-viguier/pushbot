<?php

namespace M6\Pushbot;

class Response
{
    const SUCCESS = 200;
    const FAILURE = 400;

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
