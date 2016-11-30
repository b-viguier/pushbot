<?php

namespace M6\Pushbot\Deployment\Pool\Persister;

use M6\Pushbot\Deployment;
use M6\Pushbot\Deployment\Pool;
use M6\Pushbot\Deployment\Pool\PersisterInterface;
use M6\Pushbot\Deployment\Queue;

class PhpArray implements PersisterInterface
{
    public $data;

    public function load(Pool $pool)
    {
        foreach($this->data as $project => $queue) {
            $pool[$project] = new Queue;
            foreach($queue as $deployment) {
                $pool[$project]->add(new Deployment($deployment['user']));
            }
        }
    }

    public function save(Pool $pool)
    {
        $this->data = [];
        foreach($pool as $project => $queue) {
            $this->data[$project] = [];
            foreach($queue as $deployment) {
                $this->data[$project][] = [
                    'user' => $deployment->user,
                ];
            }
        }
    }
}
