<?php
namespace isadmin\Jinritemai\Kernel\Contracts;

use ArrayAccess;

/**
 * Interface Arrayable.
 */
interface Arrayable extends ArrayAccess
{
    /**
     * 实例转化为数组
     *
     * @return array
     */
    public function toArray() : array;
}
