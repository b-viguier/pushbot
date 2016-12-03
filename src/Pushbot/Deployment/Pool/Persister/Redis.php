<?php

namespace M6\Pushbot\Deployment\Pool\Persister;

use M6\Pushbot\Deployment;
use M6\Pushbot\Deployment\Pool;
use M6\Pushbot\Deployment\Pool\PersisterInterface;

class Redis implements PersisterInterface
{
    const DEFAULT_TTL = 60 * 60 * 24 * 7;

    const KEY = ':pushbot:pool';

    public $host;

    public $namespace;

    private $redis;

    public function __construct(string $host, string $namespace)
    {
        $this->host = $host;
        $this->namespace = $namespace;
    }

    public function load(Pool $pool)
    {
        $arrayPersister = new PhpArray();
        $arrayPersister->data = json_decode(
            $this->getRedisClient()->get($this->namespace . self::KEY),
            true
        ) ?? [];
        $arrayPersister->load($pool);
    }

    public function save(Pool $pool)
    {
        $arrayPersister = new PhpArray();
        $arrayPersister->save($pool);
        $this->getRedisClient()->setex(
            $this->namespace . self::KEY,
            self::DEFAULT_TTL,
            json_encode($arrayPersister->data)
        );
    }

    protected function getRedisClient()
    {
        return $this->redis ?? $this->redis = new \Predis\Client($this->host);
    }
}
