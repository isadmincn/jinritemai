<?php
namespace isadmin\Jinritemai\Service\Shop;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package isadmin\Jinritemai\Service\Shop
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        !isset($app['shop']) && $app['shop'] = function ($app) {
            return new Client($app);
        };
    }
}
