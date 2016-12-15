<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Debug\ExceptionHandler;

ExceptionHandler::register();

$app = new Places\Application(true);
$app->run();
