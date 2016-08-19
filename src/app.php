<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/users/', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});

return $app;