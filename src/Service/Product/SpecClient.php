<?php
namespace isadmin\Jinritemai\Service\Product;

use isadmin\Jinritemai\Kernel\BaseClient;

/**
 * Class SpecClient
 * @package isadmin\Jinritemai\Service\Product
 */
class SpecClient extends BaseClient
{
    /**
     * @var string
     */
    protected $name = 'spec';

    public function add($specs, $name)
    {
        return $this->httpGet('spec/add');
    }

    public function specDetail()
    {

    }

    public function list()
    {

    }

    public function del()
    {

    }
}
