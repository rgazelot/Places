<?php

namespace Places\Messenger;

use Predis\Client as Redis;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\HttpFoundation\Request;

use Places\Messenger\Exception\AggregException;

class Aggreg
{
    private $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function aggreg(Request $request)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $url = $accessor->getValue($request->request->all(), '[entry][0][messaging][0][message][text]');
        $url = trim($url, '/');
        $explode = explode('/', $url);
        $shortCode = array_pop($explode);

        if ('' === $shortCode || null === $shortCode) {
            throw new AggregException('shortCode cannot be empty or null.');
        }

        $this->redis->set($shortCode, true);
    }
}
