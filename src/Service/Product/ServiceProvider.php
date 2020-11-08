<?php
namespace isadmin\Jinritemai\Service\Product;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package isadmin\Jinritemai\Service\Product
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['product'] = function ($app) {
            return new ProductClient($app);
        };

        $app['product_spec'] = function ($app) {
            return new SpecClient($app);
        };

        $app['product_sku'] = function ($app) {
            return new SkuClient($app);
        };
    }
}
