<?php

namespace Places\Controller;

use Silex\Application;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Places\Messenger\Exception\ChallengeException;

class Messenger
{
    public function challengeAction(Application $app, Request $request)
    {
        try {
            $app['messenger_challenge']->resolveChallenge($request);
        } catch (ChallengeException $e) {
            $app->abort(403);
        }

        return new Response($request->query->get('hub_challenge'), 200);
    }

    /**
     * Handles all webhooks come from Messenger application
     *
     * @see  https://developers.facebook.com/docs/messenger-platform/webhook-reference
     */
    public function aggregAction(Application $app, Request $request)
    {
        $app['messenger_aggreg']->aggreg($request);

        return new Response(null, 200);
    }
}
