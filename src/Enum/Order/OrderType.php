<?php
namespace isadmin\Jinritemai\Enum\Order;

/**
 * 订单类型
 */
class OrderType
{
    /**
     * 实物
     */
    const ENTITY = 0;

    /**
     * 普通虚拟
     */
    const VIRTUAL = 2;

    /**
     * POI核销
     */
    const POI_WRITE_OFF = 4;

    /**
     * 第三方核销
     */
    const THIRD_WIRTE_OFF = 5;

    /**
     * 服务市场
     */
    const SERVICE_MARKET = 6;
}
