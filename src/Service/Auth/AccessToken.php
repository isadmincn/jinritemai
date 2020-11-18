<?php
namespace isadmin\Jinritemai\Service\Auth;

use isadmin\Jinritemai\Enum\GrantType;

class AccessToken
{
    public function refreshToken($refreshToken)
    {
        return $this->app->http_client->get('/oauth2/refresh_token', [
            'query' => [
                'app_id'        => $this->app->config->get('app.app_key'),
                'app_secret'    => $this->app->config->get('app.app_secret'),
                'grant_type'    => GrantType::REFRESH_TOKEN,
                'refresh_token' => $refreshToken
            ]
        ]);
    }
}
