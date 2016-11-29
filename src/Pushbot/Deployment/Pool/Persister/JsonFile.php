<?php

namespace M6\Pushbot\Deployment\Pool\Persister;

use M6\Pushbot\Deployment;
use M6\Pushbot\Deployment\Pool;
use M6\Pushbot\Deployment\Pool\PersisterInterface;

class JsonFile implements PersisterInterface
{
    public $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function load(Pool $pool)
    {
        $arrayPersister = new PhpArray();
        $arrayPersister->data = json_decode(
            @file_get_contents($this->filename),
            true
        ) ?? [];
        $arrayPersister->load($pool);
    }

    public function save(Pool $pool)
    {
        $arrayPersister = new PhpArray();
        $arrayPersister->save($pool);
        file_put_contents(
            $this->filename,
            json_encode($arrayPersister->data)
        );
    }
}
