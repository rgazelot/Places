<?php

namespace Places\Tests;

use Silex\WebTestCase as BaseWebTestCase;

use Places\Application;

class WebTestCase extends BaseWebTestCase
{
    public function createApplication()
    {
        return new Application(true);
    }
}
