<?php

namespace M6\Pushbot;

class Pushbot
{
    private $commands = [];

    public function construct()
    {

    }

    public function registerCommand(string $className) : Pushbot
    {
        if( ! class_exists($className) ) {
            throw new \Exception("Class '$className' does not exist");
        }

        $this->commands[strtolower(end(explode('\\', $className)))] = $className;

        return $this;
    }

    public function execute(string $user = null, string $commandName = null, array $args = []) : Response
    {
        if( !isset($this->commands[$commandName]) ) {
            return $this->help($commandName == 'help' ? reset($args) : null);
        }

        return new Response(Response::SUCCESS, 'Command executed');
    }

    public function help(string $commandName = null) : Response
    {
        if(!$commandName) {
            return new Response(
                Response::SUCCESS,
                'This is the general help'
            );
        }

        return new Response(
            Response::SUCCESS,
            "This is the help for command $commandName"
        );
    }

}
