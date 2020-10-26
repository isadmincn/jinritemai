<?php
namespace isadmin\Jinritemai;

use isadmin\Jinritemai\Kernel\ServiceContainer;
use isadmin\Jinritemai\Service\Shop\ServiceProvider as ShopServiceProvider;
use isadmin\Jinritemai\Service\Product\ServiceProvider as ProductServiceProvider;
use isadmin\Jinritemai\Service\AfterSale\ServiceProvider as AfterSaleServiceProvider;
use isadmin\Jinritemai\Service\Logistics\ServiceProvider as LogisticsServiceProvider;
use isadmin\Jinritemai\Service\Order\ServiceProvider as OrderServiceProvider;
use isadmin\Jinritemai\Service\Warehouse\ServiceProvider as WarehouseServiceProvider;

/**
 * Class Application
 * @package isadmin\Jinritemai
 *
 * @property ShopClient    $shop
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        ShopServiceProvider::class,
        ProductServiceProvider::class,
        OrderServiceProvider::class,
        AfterSaleServiceProvider::class,
        LogisticsServiceProvider::class,
        WarehouseServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected $defaultConfig = [
        'app' => [
            'version' => '2',
        ],
        'request' => [
            'timeout' => 30.0,
            'base_uri' => 'https://openapi-fxg.jinritemai.com',
        ],
    ];

    /**
     * @param string $appKey
     * @param string $appSecret
     * @param array $config
     * @return Application
     * @throws Kernel\Exception\JinritemaiException
     */
    public static function make(string $appKey, string $appSecret, array $config = [])
    {
        return new static($appKey, $appSecret, $config);
    }
}
