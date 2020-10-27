<?php
namespace isadmin\Jinritemai\Service\Product;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class SkuClient
 * @package isadmin\Jinritemai\Service\Product
 */
class SkuClient extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'sku';

    /**
     * 添加SKU
     * 单个规格可设置的规格值最多是20个
     *
     * @param integer $product_id      商品id
     * @param integer $spec_id         规格id，依赖/spec/list接口的返回
     * @param string $spec_detail_ids  子规格id,最多3级,如 100041|150041|160041 （ 女款|白色|XL）
     * @param integer $stock_num       库存 (必须大于0)
     * @param integer $price           售价 (单位 分)
     * @param array $options           可选参数
     *   $options['out_sku_id']        业务方自己的sku_id，唯一需为数字字符串，max = int64
     *   $options['settlement_price']  结算价格 (单位 分)
     *   $options['code']              商品编码
     *   $options['out_warehouse_id']  外部仓库ID，需要注意，如果设置了此参数，该sku类型会变成区域库存类，原来的全国库存数据会被覆盖
     *   $options['supplier_id']       供应商ID
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/81
     */
    public function add(int $product_id, int $spec_id, string $spec_detail_ids,  int $stock_num, int $price, array $options = []) : array
    {
        $query = compact('product_id', 'spec_id', 'spec_detail_ids', 'stock_num', 'price');
        $options = array_pick($options, ['out_sku_id', 'settlement_price', 'code', 'out_warehouse_id', 'supplier_id']);

        return $this->httpGet('sku/add', array_merge($query, $options));
    }

    /**
     * 批量添加sku
     * 批量添加商品sku（每次接口调用最多添加100个）
     *
     * @param integer $product_id      商品id
     * @param integer $spec_id         规格id，依赖/spec/list接口的返回
     * @param string $spec_detail_ids  子规格id,最多3级,如 100041|150041|160041 （ 女款|白色|XL）
     * @param integer $stock_num       库存 (必须大于0)
     * @param integer $price           售价 (单位 分)
     * @param array $options           可选参数
     *   $options['out_sku_id']        业务方自己的sku_id，唯一需为数字字符串，max = int64
     *   $options['settlement_price']  结算价格 (单位 分)
     *   $options['code']              商品编码
     *   $options['out_warehouse_id']  外部仓库ID，需要注意，如果设置了此参数，该sku类型会变成区域库存类，原来的全国库存数据会被覆盖
     *   $options['supplier_id']       供应商ID
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/83
     */
    public function addAll(int $product_id, int $spec_id, string $spec_detail_ids,  int $stock_num, int $price, array $options = []) : array
    {
        $query = compact('product_id', 'spec_id', 'spec_detail_ids', 'stock_num', 'price');
        $options = array_pick($options, ['out_sku_id', 'settlement_price', 'code', 'out_warehouse_id', 'supplier_id']);

        return $this->httpGet('sku/addAll', array_merge($query, $options));
    }

    /**
     * 获取商品sku列表
     * 根据商品id获取商品的sku列表
     *
     * @param integer $product_id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/82
     */
    public function list(int $product_id) : array
    {
        return $this->httpGet('sku/list', [
            'product_id' => $product_id,
        ]);
    }

    /**
     * 编辑sku价格
     *
     * @param integer $product_id 商品id
     * @param integer $sku_id     skuid
     * @param integer $price      售价（单位：分）
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/84
     */
    public function editPrice(int $product_id, int $sku_id, int $price) : array
    {
        return $this->httpGet('sku/editPrice', compact('product_id', 'sku_id', 'price'));
    }

    /**
     * 修改sku库存
     * 注：同步库存时请注意sku对应商品的状态status和check_status, 下架、删除、禁封等状态的商品不予同步sku库存
     *
     * @param integer $product_id  商品id
     * @param integer $sku_id      skuid
     * @param integer $stock_num   库存 (可以为0)
     * @param array $options       可选参数
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/85
     */
    public function syncStock(int $product_id, int $sku_id, int $stock_num, array $options = []) : array
    {
        $query = compact('product_id', 'sku_id', 'stock_num');
        $options = array_pick($options, ['out_warehouse_id', 'supplier_id', 'incremental', 'idempotent_id']);

        return $this->httpGet('sku/syncStock', array_merge($query, $options));
    }

    /**
     * 修改sku编码
     *
     * @param integer $product_id
     * @param integer $sku_id
     * @param string $code
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/86
     */
    public function editCode(int $product_id, int $sku_id, string $code) : array
    {
        return $this->httpGet('sku/editCode', compact('product_id', 'sku_id', 'code'));
    }

    /**
     * 获取商品sku详情
     *
     * @param integer $sku_id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/104
     */
    public function detail(int $sku_id) : array
    {
        return $this->httpGet('sku/detail', [
            'sku_id' => $sku_id,
        ]);
    }
}
