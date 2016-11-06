<?php

namespace M6\Pushbot\Deployment;

use M6\Pushbot\Deployment;

class Queue extends \ArrayObject
{
    public function offsetSet($index, $newval)
    {
        if( ! $newval instanceof Deployment ) {
            throw new \Exception();
        }
        return parent::offsetSet($index, $newval);
    }
}
