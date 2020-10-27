<?php
namespace isadmin\Jinritemai\Service\Order;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class Client
 * @package isadmin\Jinritemai\Service\Order
 */
class Client extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'order';

    public function list() : array
    {

    }

    /**
     * 获取订单详情
     *
     * @param integer $order_id   父订单，订单号后面需要加大写字母"A"
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/15/68
     */
    public function detail(int $order_id) : array
    {
        return $this->httpGet('order/detail', [
            'order_id' => $order_id,
        ]);
    }

    /**
     * 确认货到付款订单
     * 当货到付款订单是待确认状态（final_status=1）时，可调此接口确认订单。确认后，订单状态更新为“备货中”
     *
     * @param integer $order_id   父订单id，由orderList接口返回
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/15/69
     */
    public function stockUp(int $order_id) : array
    {
        return $this->httpGet('order/stockUp', [
            'order_id' => $order_id,
        ]);
    }

    /**
     * 取消订单
     * 取消待确认或备货中的货到付款订单（final_status=1或2）
     *
     * @param integer $order_id  父订单ID，由orderList接口返回
     * @param string $reason     取消订单的原因
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/15/72
     */
    public function cancel(int $order_id, string $reason) : array
    {
        return $this->httpGet('order/cancel', compact('order_id', 'reason'));
    }

    public function serviceList() : array
    {

    }

    public function replyService() : array
    {

    }

    public function addOrderRemark() : array
    {

    }

    public function insurance() : array
    {
        
    }
}
