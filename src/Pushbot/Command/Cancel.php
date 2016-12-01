<?php

namespace M6\Pushbot\Command;

use M6\Pushbot\Deployment;
use M6\Pushbot\Response;
use M6\Pushbot\CommandInterface;

class Cancel implements CommandInterface
{
    public function execute(Deployment\Pool $pool, string $user, array $args) : Response
    {
        $projectName = reset($args);
        if(!$projectName) {
            $response = $this->help();
            $response->status = Response::FAILURE;

            return $response;
        }

        if(!isset($pool[$projectName])) {
            return new Response(
                Response::FAILURE,
                'No job for this project'
            );
        }

        $queue = $pool[$projectName];
        $deployment = $queue->getByUser($user);
        if(!$deployment) {
            return new Response(
                Response::FAILURE,
                'You have no job for this project'
            );
        }

        $isFirst = $deployment === $queue->getFirst();
        $queue->removeByUser($user);
        $response = new Response(
            Response::SUCCESS,
            'Done'
        );

        if (0 == count($queue)) {
            unset($pool[$projectName]);
        } elseif ($isFirst) {
            $response->body .= "\n Hey {$queue->getFirst()->user} ! It's your turn :)";
        }

        return $response;
    }

    public function help() : Response
    {
        return new Response(
            Response::SUCCESS,
            'cancel <project>'
        );
    }
}
