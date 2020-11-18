<?php
namespace isadmin\Jinritemai\Service\Warehouse;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package isadmin\Jinritemai\Service\Warehouse
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        !isset($app['warehouse']) && $app['warehouse'] = function ($app) {
            return new WarehouseClient($app);
        };

        !isset($app['warehouse_sku']) && $app['warehouse_sku'] = function ($app) {
            return new SkuClient($app);
        };
    }
}
