<?php
namespace isadmin\Jinritemai\Service\AfterSale;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class RefundClient
 * @package isadmin\Jinritemai\Service\AfterSale
 */
class RefundClient extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'refund';

    /**
     * 获取备货中有退款的订单列表
     * 在订单发货前，用户能申请退款，但此时只能申请整单退。
     *
     * @param array $options
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/17/80
     */
    public function orderList(array $options = []) : array
    {
        return $this->httpGet('refund/orderList', array_pick($options, [
            'type', 'start_time', 'end_time', 'order_by',
            'is_desc', 'page', 'size'
        ]));
    }

    /**
     * 商家处理备货中退款申请
     * 订单备货中，用户申请退款，商家处理。
     *
     * @param string $order_id  父订单ID，须带字母A
     * @param integer $type     处理方式：1：同意退款   2：不同意退款
     * @param array $options
     *          logistics_id    type = 2 时必须填写物流公司ID，由接口/order/logisticsCompanyList返回的物流公司列表中对应的ID
     *          logistics_code  type = 2 时必须填写物流单号
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/17/87
     */
    public function shopRefund(string $order_id, int $type, array $options = []) : array
    {
        $query = compact('order_id', 'type');
        $options = array_pick($options, ['logistics_id', 'logistics_code']);
        return $this->httpGet('refund/shopRefund', array_merge($query, $options));
    }
}
