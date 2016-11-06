<?php

namespace M6\Pushbot\Command;

use M6\Pushbot\Deployment;
use M6\Pushbot\Response;

class Status implements CommandInterface
{
    public function execute(Deployment\Pool $pool, string $user, array $args) : Response
    {
        $response = new Response(Response::SUCCESS);

        $response->body .= "Status" . PHP_EOL;
        foreach ($pool as $project => $deployments) {
            $response->body .= "[$project]" . PHP_EOL;
            $order = 0;
            foreach ($deployments as $deployment) {
                $response->body .= sprintf('[%d] %s', ++$order, $deployment->user) . PHP_EOL;
            }
        }

        return $response;
    }

    public function help() : Response
    {
        return new Response(
            Response::SUCCESS,
            'This is the status command'
        );
    }
}
