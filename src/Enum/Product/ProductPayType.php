<?php
namespace isadmin\Jinritemai\Enum\Product;

/**
 * 商品支持的支付类型
 */
class ProductPayType
{
    /**
     * 货到付款
     */
    const CASH_ON_DELIVERY = 0;

    /**
     * 在线支付
     */
    const ONLINE_PAY = 1;

    /**
     * 两者都支持
     */
    const BOTH = 2;
}
