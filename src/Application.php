<?php
namespace isadmin\Jinritemai;

use isadmin\Jinritemai\Kernel\ServiceContainer;
use isadmin\Jinritemai\Service\Shop\Client as ShopClient;
use isadmin\Jinritemai\Service\Shop\ServiceProvider as ShopServiceProvider;

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
            'base_uri' => 'https://openapi-fxg.Jinritemai.com',
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
