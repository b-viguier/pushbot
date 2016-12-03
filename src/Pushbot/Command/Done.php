<?php

namespace M6\Pushbot\Command;

use M6\Pushbot\Deployment;
use M6\Pushbot\Response;
use M6\Pushbot\CommandInterface;

class Done implements CommandInterface
{
    use Helper\ProjectCommand;

    public function execute(Deployment\Pool $pool, string $user, array $args) : Response
    {
        $projectName = $this->extractProjectName($args);

        $this->projectMustExist($projectName, $pool);

        $queue = $pool[$projectName];
        if($queue->getFirst()->user != $user) {
            return new Response(
                Response::FAILURE,
                'You are not the owner of the current job'
            );
        }

        $queue->removeFirst();
        $response = new Response(
            Response::SUCCESS,
            'Done'
        );

        if(count($queue)) {
            $response->body .= "\n Hey @{$queue->getFirst()->user} ! It's your turn :)";
        } else {
            unset($pool[$projectName]);
        }

        return $response;
    }

    public function help() : Response
    {
        return new Response(
            Response::SUCCESS,
            'done <project>'
        );
    }

}
