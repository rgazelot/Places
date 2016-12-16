<?php

namespace Places\Controller;

use Silex\Application;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Messenger
{
    public function homeAction(Application $app)
    {
        return new Response('ok', 200);
    }

    public function challengeAction(Application $app, Request $request)
    {
        return new Response($request->query->get('hub')['challenge'], 200);
    }

    /**
     * Handles all webhooks come from Messenger application
     *
     * @see  https://developers.facebook.com/docs/messenger-platform/webhook-reference
     */
    public function aggregAction(Application $app, Request $request)
    {
        $entry = $request->request->get('entry');
        $instagramUrl = $entry[0]['messaging'][0]['text'];
        $explode = explode('/', $instagramUrl);
        $code = array_pop($explode);

        $app['redis']->set($code, true);

        return new Response($instagramUrl, 200);
    }
}
