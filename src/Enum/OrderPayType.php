<?php
namespace isadmin\Jinritemai\Enum;

/**
 * 订单支付类型
 */
class OrderPayType
{
    // 货到付款
    const CASH_ON_DELIVERY = 0;

    // 微信支付
    const WECHAT_PAY = 1;
    
    // 支付宝
    const ALIPAY = 2;
}
