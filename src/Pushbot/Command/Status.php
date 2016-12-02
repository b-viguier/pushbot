<?php

namespace M6\Pushbot\Command;

use M6\Pushbot\CommandInterface;
use M6\Pushbot\Deployment;
use M6\Pushbot\Exception\ResponseException;
use M6\Pushbot\Response;

class Status implements CommandInterface
{
    use Helper\ProjectCommand;

    public function execute(Deployment\Pool $pool, string $user, array $args) : Response
    {
        $response = new Response(Response::SUCCESS);

        $projects = array_keys($pool->getArrayCopy());
        try {
            $projects = array_intersect(
                [$this->extractProjectName($args)],
                $projects
            );
        } catch (ResponseException $e) {
            // Keep default values
        }

        if (count($projects) == 0) {
            $response->body = 'Nothing to show…';
        } else {
            foreach ($projects as $project) {
                $response->body .= $this->projectStatus($project, $pool[$project]) . PHP_EOL;
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

    protected function projectStatus(string $project, Deployment\Queue $queue) : string
    {
        return sprintf(
            "[%s] %s",
            $project,
            implode(',', array_column($queue->getArrayCopy(), 'user'))
        );
    }
}
