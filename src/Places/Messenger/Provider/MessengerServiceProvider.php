<?php

namespace Places\Messenger\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Places\Messenger\Challenge;
use Places\Messenger\Aggreg;

class MessengerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['messenger_challenge'] = function ($app) {
            return new Challenge($app['parameters']['webhook_messenger_verify_token']);
        };
    }
}
