<?php
namespace isadmin\Jinritemai\Service\Product;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class ProductClient
 * @package isadmin\Jinritemai\Service\Product
 */
class ProductClient extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'product';

    /**
     * 获取商品详情
     *
     * @param string $product_id  商品id
     * @param string $show_draft  "true"：读取草稿数据；"false"：读取上架数据
     * @return array
     * @throws \isadmin\Jinritemai\Exception\HttpRequestException
     * @throws \isadmin\Jinritemai\Exception\JsonException
     */
    public function detail(string $product_id, $show_draft = 'false')
    {
        return $this->httpGet('product/detail', [
            'product_id' => $product_id,
            'show_draft' => $show_draft,
        ]);
    }

    public function getGoodsCategory()
    {
        
    }

    public function add()
    {

    }

    public function edit()
    {

    }

    public function del()
    {

    }

    public function getCateProperty()
    {

    }
}
