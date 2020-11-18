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
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $userConfig = [];

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

        $this->userConfig = $config;

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

    public function getConfig()
    {
        return array_replace_recursive([
            'app' => [
                'version' => '2',
                'type'    => AppType::TOOL_APP,
            ],
            'request' => [
                'timeout' => 5.0,
                'base_uri' => 'https://openapi-fxg.jinritemai.com',
            ],
            'oauth' => [
                'url' => 'https://fxg.jinritemai.com/index.html#/ffa/open/applicationAuthorize',
            ]
        ], $this->defaultConfig, $this->userConfig);
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
