<?php
namespace isadmin\Jinritemai\Kernel;

use GuzzleHttp\Exception\GuzzleException;
use isadmin\Jinritemai\Kernel\ServiceContainer;
use isadmin\Jinritemai\Kernel\Contracts\AccessTokenInterface;
use isadmin\Jinritemai\Exception\HttpRequestException;

abstract class AccessToken implements AccessTokenInterface
{
    /**
     * @var \isadmin\Jinritemai\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * AccessToken constructor.
     *
     * @param \isadmin\Jinritemai\Kernel\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * 获取AccessToken
     *
     * @return array
     */
    public function getToken() : array
    {
        return $this->requestToken();
    }

    /**
     * 请求AccessToken和RefreshToken
     *
     * @return array
     */
    protected function requestToken() : array
    {
        try {
            $resp = $this->app->http_client->get($this->getPath(), [
                'query' => $this->getCredentials()
            ]);
        } catch (GuzzleException $e) {
            throw new HttpRequestException($e->getMessage(), $e->getCode());
        }

        $respArr = json_decode($resp->getBody()->getContents(), true);

        $errno = $respArr['err_no'] ?? $respArr['errno'] ?? 0;
        $message = $respArr['message'];
        if ($errno !== 0) {
            throw new HttpRequestException($message, $errno);
        }

        return [
            $respArr['data']['access_token'] ?? '',
            $respArr['data']['refresh_token'] ?? '',
        ];
    }

    /**
     * 请求路径
     *
     * @return string
     */
    abstract protected function getPath() : string;

    /**
     * 请求凭据
     *
     * @return array
     */
    abstract protected function getCredentials(): array;
}
