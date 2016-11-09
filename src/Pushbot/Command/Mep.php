<?php

namespace M6\Pushbot\Command;

use M6\Pushbot\Deployment;
use M6\Pushbot\Response;
use M6\Pushbot\CommandInterface;

class Mep implements CommandInterface
{
    public function execute(Deployment\Pool $pool, string $user, array $args) : Response
    {
        $projectName = reset($args);
        if(!$projectName) {
            $response = $this->help();
            $response->status = Response::FAILURE;

            return $response;
        }

        $queue = $pool[$projectName] ?? $pool[$projectName] = new Deployment\Queue();
        $queue[] = new Deployment($user);

        return new Response(
            Response::SUCCESS,
            'Done'
        );
    }

    public function help() : Response
    {
        return new Response(
            Response::SUCCESS,
            'mep <project>'
        );
    }

}
