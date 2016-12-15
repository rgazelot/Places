<?php

namespace Places\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Predis\Client as Redis;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['redis'] = function () {
            return new Redis;
        };
    }
}
