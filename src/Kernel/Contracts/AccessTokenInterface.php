<?php
namespace isadmin\Jinritemai\Kernel\Contracts;

/**
 * Interface AccessTokenInterface
 */
interface AccessTokenInterface
{
    /**
     * @return array
     */
    public function getToken(): array;
}
