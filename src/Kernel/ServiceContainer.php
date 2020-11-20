<?php
namespace isadmin\Jinritemai\Kernel;

use isadmin\Jinritemai\Kernel\Providers\ConfigServiceProvider;
use isadmin\Jinritemai\Kernel\Providers\HttpClientServiceProvider;
use isadmin\Jinritemai\Kernel\Providers\RequestServiceProvider;
use isadmin\Jinritemai\Enum\AppType;
use isadmin\Jinritemai\Exception\BaseException;
use Pimple\Container;

/**
 * Class ServiceContainer
 * @package isadmin\Jinritemai\Kernel
 *
 * @property \isadmin\Jinritemai\Kernel\Config        $config
 * @property \Guzzlehttp\Client                       $http_client
 * @property Symfony\Component\HttpFoundation\Request $request
 */
class ServiceContainer extends Container
{
    /**
     * @var array
     */
    protected $defaultConfig = [
        'app' => [
            'version' => '2',
            'type'    => AppType::SELF_APP,
        ],
        'request' => [
            'timeout' => 5.0,
            'base_uri' => 'https://openapi-fxg.jinritemai.com',
        ],
        'oauth_base_url' => 'https://fxg.jinritemai.com/index.html#/ffa/open/applicationAuthorize',
    ];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * 授权码
     *
     * @var string
     */
    protected $code;

    /**
     * ServiceContainer constructor.
     *
     * @param string $app_key
     * @param string $app_secret
     * @param array $config
     * @throws BaseException
     */
    public function __construct(string $app_key, string $app_secret, array $config = [])
    {
        parent::__construct();

        $config = array_merge($config, compact('app_key', 'app_secret'));
        $this->config = array_replace_recursive($this->defaultConfig, $config);

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
        return array_merge([
            ConfigServiceProvider::class,
            HttpClientServiceProvider::class,
            RequestServiceProvider::class,
        ], $this->providers);
    }

    /**
     * 获得完整配置
     *
     * @return array
     */
    public function getConfig() : array
    {
        return $this->config;
    }

    /**
     * 设置授权码
     *
     * @param string $code
     * @return self
     */
    public function setCode(string $code) : self
    {
        if (isset($this->config['app']['type']) && $this->config['app']['type'] == AppType::TOOL_APP) {
            $this->code = $code;
        }

        return $this;
    }

    /**
     * 获取授权码
     *
     * @return string
     */
    public function getCode() : string
    {
        return $this->code;
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
