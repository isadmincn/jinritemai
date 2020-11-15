<?php
namespace isadmin\Jinritemai\Enum;

/**
 * 授权类型
 */
class GrantType
{
    /**
     * 自用型应用获取access_token
     */
    const AUTHORIZATION_SELF = 'authorization_self';

    /**
     * 工具型应用获取access_token
     */
    const AUTHORIZATION_CODE = 'authorization_code';

    /**
     * 刷新access_token
     */
    const REFRESH_TOKEN = 'refresh_token';
}
