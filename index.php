<?php

require './vendor/autoload.php';

use isadmin\Jinritemai\Application;

$app = Application::make('appkey', 'appsecret');

$app->shop->getBrandList();