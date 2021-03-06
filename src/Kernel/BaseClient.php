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
     * BaseClient constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
        $this->httpClient = $this->app->http_client;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
        $app_key = $this->app->config->get('app_key');
        $method = str_replace('/', '.', $path);
        $param_json = $this->buildParameterJson($query);
        $timestamp = $this->getCurrentTime();
        $v = $this->app->config->get('app.version');

        // 获取授权
        list($access_token, $refresh_token) = $this->app->access_token->getToken();

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
        $app_secret = $this->app->config->get('app_secret');

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
        try {
            $response = $this->httpClient->request($method, $url, $options);
        } catch (GuzzleException $e) {
            throw new HttpRequestException($e->getMessage(), $e->getCode());
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $errno = $responseArray['err_no'] ?? $responseArray['errno'] ?? 0;
        $message = $responseArray['message'];
        if ($errno !== 0) {
            throw new HttpRequestException($message, $errno);
        }

        return $responseArray['data'] ?? [];
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
