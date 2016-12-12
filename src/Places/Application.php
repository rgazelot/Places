<?php

namespace Places;

use Silex\Application as BaseApplication;

use Places\Provider\WebhookProvider;

class Application extends BaseApplication
{
    public function __construct($debug = false)
    {
        parent::__construct();

        $this['debug'] = $debug;

        $this->mount('/', new WebhookProvider);
    }
}
