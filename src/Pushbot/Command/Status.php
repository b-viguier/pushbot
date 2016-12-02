<?php

namespace M6\Pushbot\Command;

use M6\Pushbot\CommandInterface;
use M6\Pushbot\Deployment;
use M6\Pushbot\Response;

class Status implements CommandInterface
{
    public function execute(Deployment\Pool $pool, string $user, array $args) : Response
    {
        $response = new Response(Response::SUCCESS);

        if(count($pool) == 0 ) {
            $response->body = 'Nothing to show…';
        } else {
            $response->body .= "Status" . PHP_EOL;
            foreach ($pool as $project => $deployments) {
                $response->body .= sprintf(
                    "[%s] %s",
                    $project,
                    implode(',', array_column($deployments->getArrayCopy(), 'user'))
                );
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
