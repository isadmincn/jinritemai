<?php
namespace isadmin\Jinritemai\Service\Product;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class SpecClient
 * @package isadmin\Jinritemai\Service\Product
 */
class SpecClient extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'spec';

    /**
     * 添加规格
     * 1. 一个规格组下，组合总数不能超过600
     * 2. 单个规格值数量不能超过20个，比如“颜色”不能超过20种
     *
     * @param string $specs 店铺通用规格，能被同类商品通用。多规格用^分隔，父规格与子规格用|分隔，子规格用,分隔
     * @param string $name  如果不填，则规格名为子规格名用 "-" 自动生成
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/62
     */
    public function add(string $specs, string $name = null) : array
    {
        $query = ['specs' => $specs];
        if (!empty($name)) {
            $query['name'] = $name;
        }

        return $this->httpGet('spec/add', $query);
    }

    /**
     * 获取规格详情
     * 1. 一个规格组下，组合总数不能超过600
     * 2. 单个规格值数量不能超过20个，比如“颜色”不能超过20种
     *
     * @param integer $id 规格id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/63
     */
    public function specDetail(int $id) : array
    {
        return $this->httpGet('spec/specDetail', ['id' => $id]);
    }

    /**
     * 获取规格列表
     *
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/64
     */
    public function list() : array
    {
        return $this->httpGet('spec/list');
    }

    /**
     * 删除规格
     *
     * @param integer $id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/14/65
     */
    public function del(int $id) : array
    {
        return $this->httpGet('spec/del', ['id' => $id]);
    }
}
