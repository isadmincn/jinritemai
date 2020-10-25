<?php
namespace isadmin\Jinritemai\Service\Shop;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class Client
 * @package isadmin\Jinritemai\Service\Shop
 */
class Client extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'shop';

    /**
     * 获取店铺的已授权品牌列表
     * 
     * @return array
     * @throws \isadmin\Jinritemai\Exception\HttpRequestException
     * @throws \isadmin\Jinritemai\Exception\JsonException
     */
    public function brandList()
    {
        return $this->httpGet('shop/brandList');
    }
}
