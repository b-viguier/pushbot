<?php

namespace M6\Pushbot\Deployment;

use M6\Pushbot\Deployment;

class Pool extends \ArrayObject
{
    public function offsetSet($index, $newval)
    {
        if( ! $newval instanceof Deployment\Queue) {
            throw new \Exception();
        }
        return parent::offsetSet($index, $newval);
    }
}
