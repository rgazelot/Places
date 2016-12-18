<?php

namespace Places\Instagram\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Places\Instagram\Entity\MediaRepository;
use Places\Instagram\InstagramClient;
use Places\Instagram\Instagram;

class InstagramServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['instagram_media_repository'] = function ($app) {
            return new MediaRepository($app['redis']);
        };

        $app['instagram_client'] = function ($app) {
            return new InstagramClient($app['parameters']['instagram_access_token']);
        };

        $app['instagram'] = function ($app) {
            return new Instagram($app['instagram_client'], $app['instagram_media_repository']);
        };
    }
}
