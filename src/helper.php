<?php

if (!function_exists('array_pick')) {
    /**
     * 获取数组指定的子集
     *
     * @param array $array
     * @param array $keys
     * @return array
     */
    function array_pick(array $array, array $keys) : array
    {
        return array_intersect_key($array, array_flip($keys));
    }
}