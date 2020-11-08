<?php
namespace isadmin\Jinritemai\Kernel;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use isadmin\Jinritemai\Enum\AppType;
use isadmin\Jinritemai\Exception\HttpRequestException;
use isadmin\Jinritemai\Exception\JsonException;
use isadmin\Jinritemai\Enum\GrantType;
use isadmin\Jinritemai\Exception\BaseException;

/**
 * Class BaseClient
 * @package isadmin\Jinritemai\Kernel
 */
abstract class BaseClient
{
    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $code;

    /**
     * BaseClient constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 获取授权地址
     * @param string $redirectUri
     * @param string $state
     * @return string
     */
    public function getOAuthUrl($redirectUri, $state) : string
    {
        return $this->app->getOAuthUrl() . '?' . http_build_query([
            'app_id'        => $this->app->getAppKey(),
            'response_type' => 'code',
            'redirect_uri'  => $redirectUri,
            'state'         => $state,
        ]);
    }

    /**
     * 请求access token信息
     * @param string $code
     * @param array
     */
    public function getSelfAccessToken()
    {
        return $this->request('/oauth2/access_token', 'GET', [
            'query' => [
                'app_id'     => $this->app->getAppKey(),
                'app_secret' => $this->app->getAppSecret(),
                'grant_type' => GrantType::AUTHORIZATION_SELF,
            ]
        ]);
    }

    /**
     * 设置授权code
     *
     * @param string $code
     * @return void
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * 请求access token信息
     * @param array
     */
    public function getAccessToken()
    {
        if (empty($this->code)) {
            throw new BaseException('没有设置code');
        }

        return $this->request('/oauth2/access_token', 'GET', [
            'query' => [
                'app_id'     => $this->app->getAppKey(),
                'app_secret' => $this->app->getAppSecret(),
                'grant_type' => GrantType::AUTHORIZATION_CODE,
                'code' => $this->code,
            ]
        ]);
    }

    /**
     * 刷新access token信息
     * @param string $refreshToken
     */
    public function getRefreshToken($refreshToken)
    {
        return $this->request('/oauth2/refresh_token', 'GET', [
            'query' => [
                'app_id'        => $this->app->getAppKey(),
                'app_secret'    => $this->app->getAppSecret(),
                'grant_type'    => GrantType::REFRESH_TOKEN,
                'refresh_token' => $refreshToken
            ]
        ]);
    }

    /**
     * @param string $path
     * @param array $query
     * @return array
     * @throws HttpRequestException
     * @throws JsonException
     */
    public function httpGet(string $path, array $query = [])
    {
        $app_key = $this->app->getAppKey();
        $method = str_replace('/', '.', $path);
        $param_json = $this->buildParameterJson($query);
        $timestamp = $this->getCurrentTime();
        $v = $this->app->getAppVersion();
        // 自有应用和工具型应用不同的获取access_token的方式
        if ($this->app->getAppType() == AppType::SELF_APP) {
            $access_token = $this->getSelfAccessToken()['access_token'];
        } else {
            $access_token = $this->getAccessToken()['access_token'];
        }

        $sign = $this->makeSign(compact('app_key', 'method', 'param_json', 'timestamp', 'v'));
        return $this->request($path, 'GET', [
            'query' => compact('app_key', 'access_token', 'method', 'param_json', 'timestamp', 'v', 'sign'),
        ]);
    }

    /**
     * @param array $params  参数数组，该数组只可能是一维数组
     * @return string
     * @throws JsonException
     */
    protected function buildParameterJson(array $params)
    {
        $params = array_map(function ($item) {
            return (is_bool($item) || is_string($item)) ? $item : (string)$item;
        }, $params);

        if (empty($params)) {
            return '{}';
        }

        ksort($params);
        $jsonStr = json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $jsonStr = str_replace('&', '\u0026', $jsonStr);
        $jsonStr = str_replace('<', '\u003c', $jsonStr);
        $jsonStr = str_replace('>', '\u00ce', $jsonStr);

        return $jsonStr;
    }

    /**
     * @param array $arr
     * @return array
     */
    protected function sortByKey(array $arr)
    {
        foreach ($arr as $k => &$v) {
            $v = (string)$v;
        }
        ksort($arr, SORT_STRING);
        return $arr;
    }

    /**
     * @return string
     */
    protected function getCurrentTime()
    {
        return date('Y-m-d H:i:s', time());
    }

    protected function makeSign(array $credentials)
    {
        $combine = '';
        foreach ($this->sortByKey($credentials) as $k => $v) {
            $combine .= $k . $v;
        }
        $app_secret = $this->app->getAppSecret();
        return md5($app_secret . $combine . $app_secret);
    }

    /**
     * @param $url
     * @param string $method
     * @param array $options
     * @return array
     * @throws HttpRequestException
     */
    public function request($url, $method = 'GET', array $options = [])
    {
        $request = $this->app->getConfig()['request'];

        $options ['base_uri'] = $request['base_uri'];
        $options ['timeout'] = $request['timeout'];

        try {
            $response = $this->getHttpClient()->request($method, $url, $options);
        } catch (GuzzleException $e) {
            throw new HttpRequestException;
        }
        $responseArray = json_decode($response->getBody(), true);

        $errno = $responseArray['err_no'] ?? $responseArray['errno'] ?? 0;
        $message = $responseArray['message'];
        if ($errno !== 0) {
            throw new HttpRequestException($message, $errno);
        }

        return $responseArray['data'] ?? [];
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient()
    {
        if (!($this->httpClient instanceof ClientInterface)) {
            $this->httpClient = new Client();
        }
        return $this->httpClient;
    }

    public function __call($name, $arguments)
    {
        $path = $this->name . '/' . $name;
        $query = [];
        if (isset($arguments[0])) {
            // 先校验必选参数是否都有设置
            $query = $arguments;
            if (isset($arguments[1])) {

            }
        }
        return $this->httpGet($path, $query);
    }
}
