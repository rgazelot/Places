<?php

namespace Places\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class WebhookProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'Places\Controller\Webhook::webhookAction')
                    ->bind('webhook');

        return $controllers;
    }
}
