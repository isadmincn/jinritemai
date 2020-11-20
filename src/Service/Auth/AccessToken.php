<?php
namespace isadmin\Jinritemai\Service\Auth;

use isadmin\Jinritemai\Enum\AppType;
use isadmin\Jinritemai\Enum\GrantType;
use isadmin\Jinritemai\Exception\InvalidArgumentException;
use isadmin\Jinritemai\Kernel\AccessToken as BaseAccessToken;

class AccessToken extends BaseAccessToken
{
    protected function getCredentials(): array
    {
        $app_type = $this->app->config->get('app.type', AppType::SELF_APP);
        if ($app_type == AppType::SELF_APP) {
            return [
                'app_id'     => $this->app->config->get('app_key'),
                'app_secret' => $this->app->config->get('app_secret'),
                'grant_type' => GrantType::AUTHORIZATION_SELF,
            ];
        } else {
            if (empty($this->app->getCode())) {
                throw new InvalidArgumentException('没有设置授权码');
            }

            return [
                'app_id'     => $this->app->config->get('app_key'),
                'app_secret' => $this->app->config->get('app_secret'),
                'grant_type' => GrantType::AUTHORIZATION_CODE,
                'code' => $this->app->getCode(),
            ];
        }
    }

    protected function getPath() : string
    {
        return '/oauth2/access_token';
    }
}
