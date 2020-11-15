<?php
namespace isadmin\Jinritemai\Enum\Order;

/**
 * 优惠券类型
 */
class CouponInfoType
{
    /**
     * 平台折扣券 (平台承担)
     */
    const PLATFORM_DISCOUNT = 1;

    /**
     * 平台直减券 (平台承担)
     */
    const PLATFORM_DEDUCT = 2;

    /**
     * 平台满减券 (平台承担)
     */
    const PLATFORM_FULL_REDUCE = 3;

    /**
     * 品类折扣券 (暂未开放)
     */
    const CATEGORY_DISCOUNT = 11;

    /**
     * 品类直减券 (暂未开放)
     */
    const CATEGORY_DEDUCT = 12;

    /**
     * 品类满减券 (暂未开放)
     */
    const CATEGORY_FULL_REDUCE = 13;

    /**
     * 店铺折扣券 (店铺承担)
     */
    const SHOP_DISCOUNT = 21;

    /**
     * 店铺直减券 (店铺承担)
     */
    const SHOP_DEDUCT = 22;

    /**
     * 店铺满减券 (店铺承担)
     */
    const SHOP_FULL_REDUCE = 23;

    /**
     * 渠道折扣券 (平台承担)
     */
    const CHANNEL_DISCOUNT = 31;

    /**
     * 渠道直减券 (平台承担)
     */
    const CHANNEL_DEDUCT = 32;

    /**
     * 渠道满减券 (平台承担)
     */
    const CHANNEL_FULL_REDUCE = 33;

    /**
     * 单品折扣券 (店铺承担)
     */
    const PRODUCT_DISCOUNT = 41;

    /**
     * 单品直减券 (店铺承担)
     */
    const PRODUCT_DEDUCT = 42;

    /**
     * 单品满减券 (店铺承担)
     */
    const PRODUCT_FULL_REDUCE = 43;
}
