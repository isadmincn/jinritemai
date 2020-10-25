<?php
namespace isadmin\Jinritemai\Service\Logistics;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package isadmin\Jinritemai\Service\Logistics
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['logistics'] = function ($app) {
            return new LogisticsClient($app);
        };

        $app['address'] = function ($app) {
            return new AddressClient($app);
        };
    }
}
