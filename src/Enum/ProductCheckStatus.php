<?php
namespace isadmin\Jinritemai\Enum;

/**
 * 商品的审核状态
 */
class ProductCheckStatus
{
    // 默认
    const DEFAULT = 0;

    const NO_AUDIT = 1;

    const AUDITING = 2;

    const AUDITED = 3;

    const AUDIT_REJECT = 4;

    const BAN = 5;
}
