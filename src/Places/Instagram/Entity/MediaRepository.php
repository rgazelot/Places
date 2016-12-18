<?php

namespace Places\Instagram\Entity;

use Predis\Client as Redis;

class MediaRepository
{
    const MEDIA_KEY = "m:%s";

    private $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function persist(Media $media)
    {
        // Something with the Serializer Component could be used here.

        $this->redis->hmset(
            sprintf(self::MEDIA_KEY, $media->getId()),
            'id', $media->getId(),
            'location_id', $media->getLocation()->getId(),
            'location_name', $media->getLocation()->getName(),
            'location_latitude', $media->getLocation()->getLatitude(),
            'location_longitude', $media->getLocation()->getLongitude()
        );
    }
}
