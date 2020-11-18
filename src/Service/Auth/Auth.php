<?php
namespace isadmin\Jinritemai\Service\Auth;

use isadmin\Jinritemai\Enum\AppType;
use isadmin\Jinritemai\Enum\GrantType;
use isadmin\Jinritemai\Exception\BaseException;
use isadmin\Jinritemai\Kernel\BaseClient;

class Auth extends BaseClient
{
    public function getToken(string $grant_code = '')
    {
        return $this->app->config->get('app.type', AppType::SELF_APP) == AppType::SELF_APP ?
            $this->authSelf() :
            $this->authCode($grant_code);
    }

    protected function authSelf()
    {
        return $this->request('/oauth2/access_token', 'GET', [
            'query' => [
                'app_id'     => $this->app->config->get('app.app_key'),
                'app_secret' => $this->app->config->get('app.app_secret'),
                'grant_type' => GrantType::AUTHORIZATION_SELF,
            ]
        ]);
    }

    protected function authCode($grant_code)
    {
        if (empty($grant_code)) {
            throw new BaseException('没有设置授权码');
        }

        return $this->request('/oauth2/access_token', 'GET', [
            'query' => [
                'app_id'     => $this->app->config->get('app.app_key'),
                'app_secret' => $this->app->config->get('app.app_secret'),
                'grant_type' => GrantType::AUTHORIZATION_CODE,
                'code' => $grant_code,
            ]
        ]);
    }
}
