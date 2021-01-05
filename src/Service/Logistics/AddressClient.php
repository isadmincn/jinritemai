<?php
namespace isadmin\Jinritemai\Service\Logistics;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class AddressClient
 * @package isadmin\Jinritemai\Service\Logistics
 */
class AddressClient extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'address';

    /**
     * 获取省列表
     *
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/16/101
     */
    public function provinceList() : array
    {
        return $this->httpGet('address/provinceList');
    }

    /**
     * 获取市列表
     *
     * @param integer $province_id 省id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/16/102
     */
    public function cityList($province_id) : array
    {
        return $this->httpGet('address/cityList', [
            'province_id' => $province_id,
        ]);
    }

    /**
     * 获取区列表
     *
     * @param integer $city_id  市id
     * @return array
     * @link https://op.jinritemai.com/docs/api-docs/16/103
     */
    public function areaList($city_id) : array
    {
        return $this->httpGet('address/areaList', [
            'city_id' => $city_id,
        ]);
    }
}
