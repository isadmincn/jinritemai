<?php
namespace isadmin\Jinritemai\Service\Product;

use isadmin\Jinritemai\Enum\ProductCheckStatus;
use isadmin\Jinritemai\Enum\ProductStatus;
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
     * @link https://op.jinritemai.com/docs/api-docs/14/56
     */
    public function detail(int $product_id, string $show_draft = 'false') : array
    {
        return $this->httpGet('product/detail', [
            'product_id' => $product_id,
            'show_draft' => $show_draft,
        ]);
    }

    /**
     * 商品列表
     *
     * @param integer $page    页码，默认0
     * @param integer $size    每页数量，默认10
     * @param array   $options 可选参数，status商品上下架状态，check_status商品审核状态
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/57
     */
    public function list(int $page = 0, int $size = 10, array $options = []) : array
    {
        $query = compact('page', 'size');
        $options = array_pick($options, ['status', 'check_status']);

        return $this->httpGet('product/list', array_merge($query, $options));
    }

    /**
     * 获取商品分类列表
     *
     * @param integer $cid  父分类id，顶级分类的父分类id为0
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/58
     */
    public function getGoodsCategory(int $cid = 0) : array
    {
        return $this->httpGet('product/getGoodsCategory', [
            'cid' => $cid,
        ]);
    }

    /**
     * 添加商品
     *
     * @param $name            商品名称
     * @param $pic             商品轮播图
     * @param $description     商品描述
     * @param $market_price    划线价，单位分
     * @param $discount_price  售价，单位分
     * @param $first_cid       一级分类id
     * @param $second_cid      二级分类id
     * @param $third_cid       三级分类id
     * @param $spec_id         规格id
     * @param $weight          商品重量 (单位:克)
     * @param $product_format  属性名称|属性值
     * @param $pay_type        支付方式
     * @param array $options          可选选项
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/59
     */
    public function add(string $name, string $pic, string $description, int $market_price, int $discount_price, int $first_cid, 
        int $second_cid, int $third_cid, int $spec_id, int $weight, string $product_format, int $pay_type, array $options = []) : array
    {
        // 必选参数构造查询数组
        $query = compact('name', 'pic', 'description', 'market_price', 'discount_price', 'first_cid', 
                'second_cid', 'third_cid', 'spec_id', 'weight', 'product_format', 'pay_type');
        // 可选参数过滤无用数据
        $options = array_pick($options, [
            'out_product_id', 'spec_pic', 'mobile', 'recommend_remark', 'brand_id', 'presell_type',
            'presell_delay', 'presell_end_time', 'delivery_delay_day', 'quality_report', 'class_quality',
        ]);

        return $this->httpGet('product/add', array_merge($query, $options));
    }

    /**
     * 编辑商品信息
     * 编辑商品相关信息。编辑提交后默认自动提交审核，审核通过后，更新线上数据。
     *
     * @param integer $product_id
     * @param array $options
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/60
     */
    public function edit(int $product_id, array $options = []) : array
    {
        $options = array_pick($options, [
            'name', 'spec_id', 'pic', 'description', 'first_cid', 'second_cid', 'third_cid',
            'mobile', 'product_format', 'presell_type', 'presell_dela', 'presell_end_time', 'commit'
        ]);

        return $this->httpGet('product/edit', array_merge([
            'product_id' => $product_id,
        ], $options));
    }

    /**
     * 删除商品
     *
     * @param integer $product_id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/61
     */
    public function del(int $product_id) : array
    {
        return $this->httpGet('product/del', [
            'product_id' => $product_id,
        ]);
    }

    /**
     * 根据商品分类获取对应的属性列表
     * 调用API接口创建商品时，入参product_format（属性对）依赖此接口返回的值
     *
     * @param integer $first_cid   一级分类id
     * @param integer $second_cid  二级分类id
     * @param integer $third_cid   三级分类id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/94
     */
    public function getCateProperty(int $first_cid, int $second_cid, int $third_cid) : array
    {
        return $this->httpGet('product/getCateProperty', compact('first_cid', 'second_cid', 'third_cid'));
    }
}
