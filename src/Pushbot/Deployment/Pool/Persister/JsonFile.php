<?php

namespace M6\Pushbot\Deployment\Pool\Persister;

use M6\Pushbot\Deployment;
use M6\Pushbot\Deployment\Pool;
use M6\Pushbot\Deployment\Pool\PersisterInterface;
use M6\Pushbot\Deployment\Queue;

class JsonFile implements PersisterInterface
{
    public $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function load(Pool $pool)
    {
        $data = json_decode(
            file_get_contents($this->filename),
            true
        );
        foreach($data as $project => $queue) {
            $pool[$project] = new Queue;
            foreach($queue as $deployment) {
                $pool[$project][] = new Deployment($deployment['user']);
            }
        }
    }

    public function save(Pool $pool)
    {
        $data = [];
        foreach($pool as $project => $queue) {
            $data[$project] = [];
            foreach($queue as $deployment) {
                $data[$project][] = [
                    'user' => $deployment->user,
                ];
            }
        }
        file_put_contents(
            $this->filename,
            json_encode($data)
        );
    }
}
