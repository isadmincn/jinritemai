<?php
namespace isadmin\Jinritemai\Kernel;

use isadmin\Jinritemai\Enum\AppType;
use isadmin\Jinritemai\Exception\BaseException;
use Pimple\Container;

/**
 * Class ServiceContainer
 * @package isadmin\Jinritemai\Kernel
 */
class ServiceContainer extends Container
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * ServiceContainer constructor.
     *
     * @param array $config
     * @throws BaseException
     */
    public function __construct(array $config = [])
    {
        parent::__construct();
        // 合并配置
        $this->config = array_replace_recursive($this->config, $config);
        // 注册服务
        $this->registerProviders($this->getProviders());
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }

    /**
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * 获取key
     *
     * @return string
     */
    public function getAppKey()
    {
        return $this->getConfig('app.app_key');
    }

    /**
     * 获取私钥
     *
     * @return string
     */
    public function getAppSecret()
    {
        return $this->getConfig('app.app_secret');
    }

    /**
     * 获取接口版本号
     *
     * @return string
     */
    public function getAppVersion()
    {
        return (string)$this->getConfig('app.version');
    }

    /**
     * 获取App类型
     *
     * @return string
     */
    public function getAppType()
    {
        return (string)$this->getConfig('app.type');
    }

    /**
     * 获取授权地址
     *
     * @return string
     */
    public function getOAuthUrl()
    {
        return $this->getConfig('oauth.url');
    }

    /**
     * @return array|string
     */
    public function getConfig($name = '')
    {
        if (empty($name)) {
            return $this->config;
        }

        $keys = explode('.', $name);
        $config = $this->config;
        foreach ($keys as $key_name) {
            if (isset($config[$key_name])) {
                $config = $config[$key_name];
            } else {
                return '';
            }
        }

        return $config;
    }

    /**
     * @param string $id
     * @param mixed $value
     */
    public function rebind(string $id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function __get(string $id)
    {
        return $this->offsetGet($id);
    }

    /**
     * @param string $id
     * @param mixed $value
     */
    public function __set(string $id, $value)
    {
        $this->offsetSet($id, $value);
    }
}
