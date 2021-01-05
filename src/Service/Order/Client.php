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

    public function list($start_time, $end_time, array $options = []) : array
    {
        $query = compact('start_time', 'end_time');
        $options = array_pick($options, ['order_status', 'order_by', 'is_desc', 'page', 'size']);
        if (!isset($options['order_by'])) {
            $options['order_by'] = 'create_time';
        }

        return $this->httpGet('order/list', array_merge($query, $options));
    }

    /**
     * 获取订单详情
     *
     * @param string $order_id   父订单，订单号后面需要加大写字母"A"
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/15/68
     */
    public function detail($order_id) : array
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

    /**
     * 获取服务请求列表
     * 获取客服向店铺发起的服务请求列表
     *
     * @param string $start_time
     * @param string $end_time
     * @param integer $supply
     * @param array $options
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/15/74
     */
    public function serviceList(string $start_time, string $end_time, int $supply, array $options = []) : array
    {
        $query = [
            'start_time' => $start_time,
            'end_time' => $end_time,
            'supply' => $supply,
        ];
        $options = array_pick($options, ['status', 'page', 'size']);

        return $this->httpGet('order/serviceList', array_merge($query, $options));
    }

    /**
     * 回复服务请求
     * 回复客服向店铺发起的服务请求
     *
     * @param integer $id
     * @param string $reply
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/15/75
     */
    public function replyService(int $id, string $reply) : array
    {
        return $this->httpGet('order/replyService', [
            'id' => $id,
            'reply' => $reply,
        ]);
    }

    /**
     * 添加订单备注
     * 添加订单备注，给订单加旗标
     *
     * @param string $order_id
     * @param string $remark
     * @param array $options
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/15/141
     */
    public function addOrderRemark(string $order_id, string $remark, array $options = []) : array
    {
        $query = [
            'order_id' => $order_id,
            'remark' => $remark,
        ];
        $options = array_pick($options, ['is_add_star', 'star']);

        return $this->httpGet('order/addOrderRemark', array_merge($query, $options));
    }

    /**
     * 获取运费险保单详情
     * 根据订单ID，获取该订单对应的运费险保单的详细信息
     *
     * @param string $order_id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/32/135
     */
    public function insurance(string $order_id) : array
    {
        return $this->httpGet('order/insurance', [
            'order_id' => $order_id,
        ]);
    }
}
