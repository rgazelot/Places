<?php

namespace Places\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class MessengerControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'Places\Controller\Messenger::homeAction')
                    ->bind('home');

        $controllers->get('/webhook/messenger', 'Places\Controller\Messenger::challengeAction')
                    ->bind('challenge');

        $controllers->post('/webhook/messenger', 'Places\Controller\Messenger::aggregAction')
                    ->bind('aggreg');

        return $controllers;
    }
}
