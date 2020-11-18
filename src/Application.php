<?php
namespace isadmin\Jinritemai;

use isadmin\Jinritemai\Kernel\ServiceContainer;
use isadmin\Jinritemai\Service\Auth\ServiceProvider as AuthServiceProvier;
use isadmin\Jinritemai\Service\Shop\ServiceProvider as ShopServiceProvider;
use isadmin\Jinritemai\Service\Product\ServiceProvider as ProductServiceProvider;
use isadmin\Jinritemai\Service\AfterSale\ServiceProvider as AfterSaleServiceProvider;
use isadmin\Jinritemai\Service\Logistics\ServiceProvider as LogisticsServiceProvider;
use isadmin\Jinritemai\Service\Order\ServiceProvider as OrderServiceProvider;
use isadmin\Jinritemai\Service\Warehouse\ServiceProvider as WarehouseServiceProvider;

use isadmin\Jinritemai\Service\Auth\Auth;
use isadmin\Jinritemai\Service\Auth\AccessToken;
use isadmin\Jinritemai\Service\Shop\Client as ShopClient;
use isadmin\Jinritemai\Service\Product\{
    ProductClient,
    SkuClient as ProductSkuClient,
    SpecClient as ProductSpecClient
};
use isadmin\Jinritemai\Service\Order\Client as OrderClient;
use isadmin\Jinritemai\Service\Logistics\{AddressClient, LogisticsClient};
use isadmin\Jinritemai\Service\AfterSale\{AfterSaleClient, RefundClient};

use isadmin\Jinritemai\Enum\AppType;

/**
 * Class Application
 * @package isadmin\Jinritemai
 *
 * @property Auth                 $auth
 * @property AccessToken          $access_token
 * @property ShopClient           $shop
 * @property ProductClient        $product
 * @property ProductSkuClient     $product_sku
 * @property ProductSpecClient    $product_spec
 * @property OrderClient          $order
 * @property AddressClient        $address
 * @property LogisticsClient      $logistics
 * @property AfterSaleClient      $after_sale
 * @property RefundClient         $refund
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        AuthServiceProvier::class,
        ShopServiceProvider::class,
        ProductServiceProvider::class,
        OrderServiceProvider::class,
        AfterSaleServiceProvider::class,
        LogisticsServiceProvider::class,
        WarehouseServiceProvider::class,
    ];

    /**
     * @param string $appKey
     * @param string $appSecret
     * @param array $config
     * @return Application
     * @throws Kernel\Exception\JinritemaiException
     */
    public static function make(array $config = [])
    {
        return new static($config);
    }

    /**
     * 获取授权地址
     *
     * @param string $redirectUri
     * @param string $state
     * @return string
     */
    public function getOAuthUrl(string $redirectUri, string $state) : string
    {
        return $this->config->get('oauth_base_url') . '?' . http_build_query([
            'app_id'        => $this->config->get('app.app_key'),
            'response_type' => 'code',
            'redirect_uri'  => $redirectUri,
            'state'         => $state,
        ]);
    }
}
