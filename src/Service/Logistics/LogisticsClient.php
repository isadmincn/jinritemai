<?php
namespace isadmin\Jinritemai\Service\Logistics;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class LogisticsClient
 * @package isadmin\Jinritemai\Service\Logistics
 */
class LogisticsClient extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'order';

    /**
     * 获取快递公司列表
     *
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/16/76
     */
    public function companyList() : array
    {
        return $this->httpGet('order/logisticsCompanyList');
    }

    /**
     * 订单发货
     * 暂时只支持整单出库，即接口调用时入参只能传父订单号
     *
     * @param integer $order_id       父订单ID，由orderList接口返回
     * @param integer $logistics_id   物流公司ID，由接口/order/logisticsCompanyList返回的物流公司列表中对应的ID
     * @param string $logistics_code  运单号
     * @param string $company         物流公司名称
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/16/77
     */
    public function add(int $order_id, int $logistics_id, string $logistics_code, string $company = '') : array
    {
        if (empty($company)) {
            $query = compact('order_id', 'logistics_id', 'logistics_code');
        } else {
            $query = compact('order_id', 'logistics_id', 'logistics_code', 'company');
        }

        return $this->httpGet('order/logisticsAdd', $query);
    }

    /**
     * 修改发货物流
     * 修改已发货订单（final_status=3）的发货物流信息
     *
     * @param integer $order_id       父订单ID，由orderList接口返回 
     * @param integer $logistics_id   物流公司ID，由接口/order/logisticsCompanyList返回的物流公司列表中对应的ID
     * @param string $logistics_code  运单号
     * @param string $company         物流公司名称
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/16/79
     */
    public function edit(int $order_id, int $logistics_id, string $logistics_code, string $company = '') : array
    {
        if (empty($company)) {
            $query = compact('order_id', 'logistics_id', 'logistics_code');
        } else {
            $query = compact('order_id', 'logistics_id', 'logistics_code', 'company');
        }

        return $this->httpGet('order/logisticsEdit', $query);
    }
}
