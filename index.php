<?php

require './vendor/autoload.php';

use isadmin\Jinritemai\Application;
use isadmin\Jinritemai\Enum\ProductCheckStatus;
use isadmin\Jinritemai\Enum\ProductStatus;
// $app = Application::make('1111111111111111111', 'appsecret');

// $app->shop->brandList();

use isadmin\Jinritemai\Service\Product\ProductClient;
// use isadmin\Jinritemai\Application;

$product = new ProductClient(new Application('', ''));
$product->getCateProperty(1001, 1001001, 1001001001);