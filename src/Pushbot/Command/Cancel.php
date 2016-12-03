<?php

namespace M6\Pushbot\Command;

use M6\Pushbot\Deployment;
use M6\Pushbot\Response;
use M6\Pushbot\CommandInterface;

class Cancel implements CommandInterface
{
    use Helper\ProjectCommand;

    public function execute(Deployment\Pool $pool, string $user, array $args) : Response
    {
        $projectName = $this->extractProjectName($args);

        $this->projectMustExist($projectName, $pool);

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
            $response->body .= "\n Hey @{$queue->getFirst()->user} ! It's your turn :)";
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
