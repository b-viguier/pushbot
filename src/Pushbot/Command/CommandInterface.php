<?php


namespace M6\Pushbot\Command;


use M6\Pushbot\Deployment;
use M6\Pushbot\Response;

interface CommandInterface
{
    public function execute(Deployment\Pool $pool, string $user, array $args) : Response;

    public function help() : Response;
}