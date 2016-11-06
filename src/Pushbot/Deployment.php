<?php

namespace M6\Pushbot;

class Deployment
{
    public $user = '';

    public function __construct(string $user)
    {
        $this->user = $user;
    }
}
