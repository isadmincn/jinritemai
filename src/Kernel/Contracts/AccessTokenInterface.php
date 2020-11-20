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

    /**
     * @return \isadmin\Jinritemai\Kernel\Contracts\AccessTokenInterface
     */
    public function refresh(): self;
}
