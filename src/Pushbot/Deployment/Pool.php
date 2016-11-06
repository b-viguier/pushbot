<?php

namespace M6\Pushbot\Deployment;

use M6\Pushbot\Deployment;

class Pool extends \ArrayObject
{
    public function offsetSet($index, $newval)
    {
        if( ! is_subclass_of($newval, Deployment\Queue::class)) {
            throw new \Exception();
        }
        return parent::offsetSet($index, $newval);
    }
}
