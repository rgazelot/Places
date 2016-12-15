<?php

namespace Places;

use Exception;

use Silex\Application as BaseApplication;

use Symfony\Component\Yaml\Yaml;

use Places\Provider\WebhookControllerProvider;
use Places\Provider\MiddlewareProvider;
use Places\Provider\ServiceProvider;

class Application extends BaseApplication
{
    public function __construct($debug = false)
    {
        parent::__construct();

        $this['debug'] = $debug;

        $this->registerParameters();
        $this->mount('/', new WebhookControllerProvider);
        $this->register(new MiddlewareProvider);
        $this->register(new ServiceProvider);
    }

    private function registerParameters()
    {
        $path = __DIR__ . '/../../app/config/parameters.yml';

        if (!file_exists($path)) {
            throw new Exception;
        }

        $parameters = Yaml::parse(file_get_contents($path));
        $this['parameters'] = $parameters['parameters'];
    }
}
