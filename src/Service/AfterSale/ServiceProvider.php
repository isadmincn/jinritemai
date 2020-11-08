<?php
namespace isadmin\Jinritemai\Service\AfterSale;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package isadmin\Jinritemai\Service\AfterSale
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['after_sale'] = function ($app) {
            return new AfterSaleClient($app);
        };

        $app['refund'] = function ($app) {
            return new RefundClient($app);
        };
    }
}
