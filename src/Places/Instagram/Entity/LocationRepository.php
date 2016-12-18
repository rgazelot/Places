<?php

namespace Places\Instagram\Entity;

use Predis\Client as Redis;

use Places\Instagram

class LocationRepository
{
    private $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function persistFromMedia(Media $media)
    {
        $this->redis->geoadd()
    }
}
