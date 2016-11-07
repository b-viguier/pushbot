<?php
namespace M6\Pushbot\Deployment\Pool;

use M6\Pushbot\Deployment\Pool;

interface PersisterInterface
{
    public function load(Pool $pool);

    public function save(Pool $pool);
}