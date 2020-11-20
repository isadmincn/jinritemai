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
     * @return array
     */
    public function getToken(): array
    {
        $path = $this->getPath();
        $credentials = $this->getCredentials();

        try {
            $response = $this->app->http_client->get($path, [
                'query' => $credentials
            ]);
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

    /**
     * @return \EasyWeChat\Kernel\Contracts\AccessTokenInterface
     */
    public function refresh(): self
    {
        $this->getToken();
        return $this;
    }

    /**
     * request path
     *
     * @return string
     */
    abstract protected function getPath() : string;

    /**
     * Credential for get token.
     *
     * @return array
     */
    abstract protected function getCredentials(): array;
}
