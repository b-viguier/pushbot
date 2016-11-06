<?php

namespace M6\Pushbot;

use M6\Pushbot\Command\CommandInterface;
use M6\Pushbot\Deployment;

class Pushbot
{
    private $commands = [];

    private $pool;

    public function __construct(Deployment\Pool $pool)
    {
        $this->pool = $pool;
    }

    public function registerCommand(string $className) : Pushbot
    {
        if (!is_subclass_of($className, CommandInterface::class)) {
            throw new \Exception("Class '$className' does not implements " . CommandInterface::class);
        }

        $classPath = explode('\\', $className);
        $this->commands[strtolower(end($classPath))] = $className;

        return $this;
    }

    public function execute(string $user = null, string $commandName = null, array $args = []) : Response
    {
        try {
            return $this->instanciateCommand($commandName)
                ->execute($this->pool, $user, $args);
        } catch(\Exception $e) {
            return $this->help($commandName == 'help' ? reset($args) : null);
        }
    }

    public function help(string $commandName = null) : Response
    {
        try {
            return $this->instanciateCommand($commandName)
                ->help();
        } catch(\Exception $e) {
            return new Response(
                Response::SUCCESS,
                'This is the general help'
            );
        }
    }

    private function instanciateCommand(string $commandName = null) : CommandInterface
    {
        if( !isset($this->commands[$commandName]) ) {
            throw new \Exception('unknown command');
        }

        return new $this->commands[$commandName];
    }

}
