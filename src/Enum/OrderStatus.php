<?php
namespace isadmin\Jinritemai\Enum;

/**
 * 订单状态
 */
class OrderStatus
{
    // 在线支付订单待支付； 货到付款订单待确认
    const READY_PAY = 1;

    // 备货中，只有在此状态下才可发货
    const STOCK_UP = 2;

    // 已发货
    const DELIVERED = 3;

    // 已取消
    // 用户未支付时取消订单
    // 用户超时未支付，系统自动取消
    // 货到付款订单，用户拒收
    const CANCELED = 4;

    // 已完成
    // 在线支付订单，商家发货后，用户收货、拒收或者15天无物流更新
    // 货到付款订单，用户确认收货
    const FINISH = 5;

    // 退货中 用户申请退货
    const BUYER_APPLY_RETURN = 6;

    // 退货中 商家同意退货
    const SELLER_APPROVE_RETURN = 7;

    // 退货中 客服仲裁退货
    const CUSTOMER_SERVICE_ARBITRATE_RETURN = 8;

    // 已关闭 退货失败
    const RETURN_CLOSED = 9;

    // 退货中 客服同意退货
    const CUSTOMER_SERVICE_APPROVE_RETURN = 10;

    // 退货中 用户已填写物流
    const BUYER_SUBMIT_LOGISTICS_FOR_RETURN = 11;

    // 退货成功 商户同意
    const RETURN_SUCCESS = 12;

    // 退货中 在此客服仲裁
    const AGAIN_ARBITRATE_RETURN = 13;

    // 退货中 客服同意退款
    const CUSTOMER_SERVICE_APPROVE_REFUND = 14;

    // 退货 用户取消
    const BUYER_CANCEL_RETURN = 15;

    // 退款中 用户申请（备货中）
    const BUYER_APPLY_REFUND = 16;

    // 退款中 商家同意（备货中）
    const SELLER_APPROVE_REFUND = 17;

    // 退款成功 订单退款（备货中，用户申请退款，最终退款成功）
    const REFUND_SUCCESS_IN_STOCK_UP = 21;

    // 退款成功 订单退款（已发货时，用户申请退货，最终退货退款成功）
    const REFUND_SUCCESS_IN_DELIVERED = 22;

    // 退货成功 商户已退款（特指货到付款订单，已发货时，用户申请退货，最终退货退款成功）
    const SELLER_REFUNDED = 24;

    // 退款中 用户取消（备货中）
    const BUYER_CANCEL_REFUND = 25;

    // 退款中 商家拒绝（备货中）
    const SELLER_REJECT_REFUND = 26;

    // 退货中 等待买家处理（已发货，商家拒绝用户退货申请）
    const READY_BUYER_DEAL = 27;

    // 退货失败（已发货，商家拒绝用户退货申请，客服仲裁支持商家）
    const RETURN_FAILURE = 28;
}
