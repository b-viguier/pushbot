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

    public function getFirst() : Deployment
    {
        return $this->getIterator()->current();
    }

    public function removeFirst()
    {
        $this->offsetUnset($this->getIterator()->key());
    }

    public function add(Deployment $deployment)
    {
        $this[$deployment->user] = $deployment;
    }

    public function getByUser(string $user)
    {
        return $this[$user] ?? null;
    }

    public function removeByUser(string $user)
    {
        unset($this[$user]);
    }
}
