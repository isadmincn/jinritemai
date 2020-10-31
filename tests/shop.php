<?php

require __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/config.php';

use isadmin\Jinritemai\Application;

$app = new Application($config['appkey'], $config['appsecret']);
var_dump($app->shop->brandList());
