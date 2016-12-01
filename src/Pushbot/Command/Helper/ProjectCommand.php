<?php


namespace M6\Pushbot\Command\Helper;


use M6\Pushbot\Deployment\Pool;
use M6\Pushbot\Exception\ResponseException;
use M6\Pushbot\Response;

trait ProjectCommand
{
    public function extractProjectName(array $args) : string
    {
        if($projectName = reset($args)) {
            return $projectName;
        }

        throw new ResponseException(
            "Missing project name.",
            Response::FAILURE
        );
    }

    public function projectMustExist(string $projectName, Pool $pool)
    {
        if(!isset($pool[$projectName])) {
            throw new ResponseException(
                sprintf('No job for this project [%s]', $projectName),
                Response::FAILURE
            );
        }
    }
}