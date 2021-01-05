<?php
namespace isadmin\Jinritemai\Service\AfterSale;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class AfterSaleClient
 * @package isadmin\Jinritemai\Service\AfterSale
 */
class AfterSaleClient extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'afterSale';

    /**
     * 获取已发货且有售后的订单列表
     * 订单已发货，通过该接口可拉取有售后的订单：
     * 售后仅退款
     * 售后退货
     *
     * @param array $options
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/17/88
     */
    public function orderList(array $options = []) : array
    {
        return $this->httpGet('afterSale/orderList', array_pick($options, [
            'type', 'start_time', 'end_time', 'order_by',
            'is_desc', 'page', 'size'
        ]));
    }

    /**
     * 商家处理退货申请
     * 订单已发货，用户申请售后退货，商家处理。商家拒绝退货申请时，address_id是选填入参。
     * 1、address_id不为空时，取address_id对应的地址库地址，作为退货地址
     * 2、address_id为空时：
     *     如果退货地址文本信息也为空，则取店铺地址库默认退货地址**
     *     如果退货地址文本信息不为空，则取详细地址文本**
     *
     * @param string $order_id
     * @param integer $type
     * @param integer $sms_id
     * @param array $options
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/17/90
     */
    public function buyerReturn($order_id, $type, $sms_id, array $options = []) : array
    {
        $query = [
            'order_id' => $order_id,
            'type' => $type,
            'sms_id' => $sms_id,
        ];

        if ($type == 1) {
            if (empty($options['address_id'])) {
                $options = array_pick($options, [
                    'receiver_name', 'receiver_tel', 'receiver_province', 'receiver_city', 'receiver_district', 'receiver_address'
                ]);
            } else {
                $options = [];
            }
        } else {
            $options = array_pick($options, ['comment', 'evidence', 'address_id']);
        }

        return $this->httpGet('afterSale/buyerReturn', array_merge($query, $options));
    }

    /**
     * 商家确认是否收到退货
     * 用户填写退货物流后，商家处理，确认是否收到退货
     * 注：货到付款订单，调此接口确认收货，必须上传退款凭证图片。售后状态会变为24（退货成功-商户已退款）
     *
     * @param string $order_id
     * @param integer $type
     * @param array $options
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/17/91
     */
    public function firmReceive($order_id, $type, array $options = []) : array
    {
        $query = [
            'order_id' => $order_id,
            'type'     => $type,
            'register' => 1,
            'package'  => 1,
            'facade'   => 1,
            'function' => 1,
        ];
        $options = array_pick($options, ['comment', 'evidence']);

        return $this->httpGet('afterSale/firmReceive', array_merge($query, $options));
    }

    /**
     * 货到付款订单上传退款凭证
     * 货到付款订单，用户申请退货，商家确认收到退货时（final_status=12 or 14时）。如果需要上传退款凭证，需要调此接口！
     *
     * @param string $order_id
     * @param string $comment
     * @param string $evidence
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/17/92
     */
    public function uploadCompensation($order_id, $comment, $evidence) : array
    {
        return $this->httpGet('afterSale/uploadCompensation', [
            'order_id' => $order_id,
            'comment' => $comment,
            'evidence' => $evidence,
        ]);
    }

    /**
     * 商家为订单添加售后备注
     * 此接口可用于给备货中退款的订单、已发货退货/仅退款的订单，添加售后备注
     *
     * @param string $order_id
     * @param string $remark
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/17/93
     */
    public function addOrderRemark($order_id, $remark) : array
    {
        return $this->httpGet('afterSale/addOrderRemark', [
            'order_id' => $order_id,
            'remark' => $remark,
        ]);
    }

    /**
     * 根据子订单ID查询退款详情
     * 通过该接口，根据子订单ID查询退款详情信息
     * 1、订单未发货，买家申请整单退款
     * 2、订单已发货，买家申请发货后仅退款
     * 3、订单已发货，买家申请发货后退货
     *
     * @param string $order_id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/17/96
     */
    public function refundProcessDetail($order_id) : array
    {
        return $this->httpGet('afterSale/refundProcessDetail', [
            'order_id' => $order_id,
        ]);
    }

    /**
     * 商家发货后仅退款申请
     * 订单已发货，用户申请售后仅退款，商家处理
     *
     * @param string $order_id
     * @param integer $type
     * @param string $evidence
     * @param string $comment
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/17/131
     */
    public function buyerRefund($order_id, $type, $evidence, $comment = '') : array
    {
        $query = [
            'order_id' => $order_id,
            'type' => $type,
            'evidence' => $evidence,
        ];
        if (!empty($comment)) {
            $query['comment'] = $comment;
        }

        return $this->httpGet('afterSale/buyerRefund', $query);
    }
}
