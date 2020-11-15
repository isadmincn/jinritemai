<?php
namespace isadmin\Jinritemai\Enum\Product;

/**
 * 商品上架状态
 */
class ProductStatus
{
    /**
     * 上架
     */
    const ONLINE = 0;

    /**
     * 下架
     */
    const OFFLINE = 1;

    /**
     * 已删除
     */
    const DELETED = 2;
}
