<?php

include __DIR__.'/../vendor/autoload.php';

use M6\Pushbot;
use M6\Pushbot\Command;

$config = include __DIR__.'/config/config.php';

$pool = new Pushbot\Deployment\Pool();
$persister = $config['persister'] ?? new Pushbot\Deployment\Pool\Persister\PhpArray();

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