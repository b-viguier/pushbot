<?php

include __DIR__.'/../vendor/autoload.php';

use M6\Pushbot;
use M6\Pushbot\Command;

$pool = new Pushbot\Deployment\Pool();
$persister = new Pushbot\Deployment\Pool\Persister\Redis('tcp://localhost:6379', 'pushbot');

$pushbot = new Pushbot\Pushbot(
    $pool,
    $persister
);

$pushbot
    ->registerCommand(Command\Status::class)
    ->registerCommand(Command\Mep::class)
    ->registerCommand(Command\Done::class)
    ->registerCommand(Command\Cancel::class);

return $pushbot;