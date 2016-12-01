<?php

namespace M6\Pushbot\Command;

use M6\Pushbot\Deployment;
use M6\Pushbot\Response;
use M6\Pushbot\CommandInterface;

class Mep implements CommandInterface
{
    use Helper\ProjectCommand;

    public function execute(Deployment\Pool $pool, string $user, array $args) : Response
    {
        $projectName = $this->extractProjectName($args);

        $queue = $pool[$projectName] ?? $pool[$projectName] = new Deployment\Queue();

        if ($queue->getByUser($user)) {
            return new Response(
                Response::FAILURE,
                'You already have a waiting deployment'
            );
        }

        $response = new Response(Response::SUCCESS, 'Done');

        if($count = count($queue)) {
            $response = new Response(
                Response::FAILURE,
                "There is $count jobs before you… I'll notify you when it's your turn!"
            );
        }
        $queue->add(new Deployment($user));

        return $response;
    }

    public function help() : Response
    {
        return new Response(
            Response::SUCCESS,
            'mep <project>'
        );
    }

}
