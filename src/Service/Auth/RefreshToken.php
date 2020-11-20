<?php
namespace isadmin\Jinritemai\Service\Auth;

use isadmin\Jinritemai\Enum\GrantType;
use isadmin\Jinritemai\Kernel\AccessToken as BaseAccessToken;

class RefreshToken extends BaseAccessToken
{
    protected function getCredentials(): array
    {
        return [
            'app_id'        => $this->app->config->get('app_key'),
            'app_secret'    => $this->app->config->get('app_secret'),
            'grant_type'    => GrantType::REFRESH_TOKEN,
            'refresh_token' => $refreshToken,
        ];
    }

    protected function getPath() : string
    {
        return '/oauth2/refresh_token';
    }
}
