<?php

namespace Places\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class Webhook
{
    public function webhookAction(Application $app)
    {
        return new Response("foo", 200);
    }
}
