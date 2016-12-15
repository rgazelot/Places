<?php

namespace Places\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class WebhookControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'Places\Controller\Webhook::homeAction')
                    ->bind('home');

        $controllers->get('/webhook/challenge', 'Places\Controller\Webhook::messengerChallengeAction')
                    ->bind('messengerChallenge');

        $controllers->post('/webhook/messenger', 'Places\Controller\Webhook::messengerAction')
                    ->bind('messenger');

        return $controllers;
    }
}
