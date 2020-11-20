# 抖音小店SDK

[参考文档](./docs/index.md)

## 安装
```
composer require isadmin/jinritemai
```

## 配置
```php
<?php

use isadmin\Jinritemai\Enum\AppType;

return [
    'app' => [
        'app_key' => '',
        'app_secret' => '',
        // 默认
        'version' => '2',
        // 应用类型，AppType::SELF_APP为自用型应用，AppType::TOOL_APP为工具型应用
        'type'    => AppType::TOOL_APP,
    ],
    'request' => [
        'timeout' => 30.0,
        'base_uri' => 'https://openapi-fxg.jinritemai.com',
    ],
    'oauth' => [
        'url' => 'https://fxg.jinritemai.com/index.html#/ffa/open/applicationAuthorize',
    ],
];
```

## 实例化
```php
use isadmin\Jinritemai\Application;

$app = new Application($config);
print_r($app->getConfig());
```

## 访问Api
访问Api示例如下
```php
// 显示商品列表，实际调用的方法是GET /product/list
$app->product->list();
// 显示商品详情，实际调用的方法是/product/detail
$app->product->detail($product_id);
```
其中```product```是注入到app容器中的商品接口服务，支持的服务如下：
```
shop          店铺
product       商品
product_sku   商品sku
product_spec  商品规格
order         订单
address       地址
logistics     物流
after_sale    售后
refund        退款
```

## 鸣谢
[luozhenyu/JinRiTeMai](https://github.com/luozhenyu/JinRiTeMai)
[easywechat](https://github.com/overtrue/wechat)
