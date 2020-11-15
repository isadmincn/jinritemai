<?php
namespace isadmin\Jinritemai\Enum\Product;

/**
 * 商品的审核状态
 */
class ProductCheckStatus
{
    /**
     * 未提审
     */
    const NO_AUDIT = 1;

    /**
     * 审核中
     */
    const AUDITING = 2;

    /**
     * 审核通过
     */
    const AUDITED = 3;

    /**
     * 审核驳回
     */
    const AUDIT_REJECT = 4;

    /**
     * 封禁
     */
    const BANNED = 5;
}
