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
     * @link https://op.jinritemai.com/docs/api-docs/13/54
     */
    public function brandList()
    {
        return $this->httpGet('shop/brandList');
    }

    /**
     * 当前店铺信息
     * 官方文档并没有该接口的文档
     *
     * @return array
     */
    public function currentShop()
    {
        return $this->httpGet('shop/currentShop');
    }

    /**
     * 获取店铺后台供商家发布商品的类目
     *
     * @param integer $cid
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/13/234
     */
    public function getShopCategory($cid = 0)
    {
        return $this->httpGet('shop/getShopCategory', [
            'cid' => $cid
        ]);
    }
}
