<?php

namespace Places\Controller\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/webhook/messenger', 'Places\Controller\Messenger::challengeAction')
                    ->bind('challenge');

        $controllers->post('/webhook/messenger', 'Places\Controller\Messenger::aggregAction')
                    ->bind('aggreg');

        return $controllers;
    }
}
