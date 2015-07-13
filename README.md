![wechat](https://dn-coding-net-production-static.qbox.me/8db6f7ad-8efe-4626-8ccd-f8c7883240d0.png)

# wechat

基于laravel5.1开发的微信公众平台SDK，支持管理多个微信应用。

## 功能

以下是所支持的功能列表，其中打勾的为已完成功能，其他为开发中状态。

- [x] 微信接入
- [x] 获取access_token
- [x] 获取微信服务器IP地址
- [x] 被动接收普通消息
- [x] 被动接收事件消息
- [x] 被动回复消息
- [ ] 客服消息
- [ ] 多客服功能
- [ ] 群发消息
- [ ] 模板消息
- [ ] 消息加解密
- [ ] 素材管理
- [x] 用户管理
- [x] 自定义菜单管理
- [ ] 二维码
- [x] 长链接转短链接
- [ ] 数据统计
- [ ] JS-SDK
- [ ] 微信小店
- [ ] 微信卡券
- [ ] 微信门店
- [ ] 微信智能接口
- [ ] 微信智能接口
- [ ] 摇一摇周边
- [ ] 微信连Wi-Fi

## 环境要求
PHP 版本 >=5.5.9

## 安装
##### 使用composer安装
```bash
composer require "hsinlu/wechat:dev-master"
```

##### 配置laravel项目

1. 将`Hsinlu\Wechat\WechatServiceProvider`添加到laravel项目`config/app.php`中

```php
'providers' => [
	// ...

	// wechat
	Hsinlu\Wechat\WechatServiceProvider::class,
],
```

2. 将`Hsinlu\Wechat\Http\Middleware\CheckWechatSignature`添加到laravel项目`app/Http/Kernel.php`中

```php
/**
 * The application's route middleware.
 *
 * @var array
 */
protected $routeMiddleware = [
    // ...

    // wechat
    'checkWechatSignature' => \Hsinlu\Wechat\Http\Middleware\CheckWechatSignature::class,
];
```

3. 最后执行`vendor:publish`将配置文件和其他资源文件拷贝到laravel项目对应的目录

```bash
php artisan vendor:publish
```

## 使用

### 配置

在`config/wechat.php`中配置微信应用的相关参数，如果有多个应用，复制`apps`数组第一个应用配置并更改相关的配置项。

```php
<?php

return [
	// 应用的配置，支持多个应用
	'apps' => [
		// 应用的唯一标识 => 应用配置
		'应用的唯一标识' => [
		    // 应用ID
		    'AppID' => '应用ID',
		    // 应用密钥
		    'AppSecret' => '应用密钥',
		   	// 令牌
		    'Token' => '令牌',
		    // 消息是否加密 
		    'Encrypt' => false,
		    // 消息加解密密钥
		    'EncodingAESKey' => '消息加解密密钥',
		],
	],
];

```

通过`wechat()`方法生成默认的微信应用（默认为配置中的第一个），通过`wechat('应用的唯一标识')`生成其他微信应用。

### 微信接入

SDK中提供了`wechat/access`路由供应用接入使用，如果您的域名是`http://hsinlu.com`，那么您在微信中配置的**服务器地址**则是`http://hsinlu.com/wechat/access`。

对于多个应用，配置的**服务器地址**则需要在`wechat/access`之上添加**应用的唯一标识**，如`http://hsinlu.com/wechat/access/wx1d3e8db24427e3a6`，SDK在收到微信推送的消息时，会根据**应用的唯一标识**，来判断是哪个应用。

### 被动接收消息

#### 被动接收普通消息

被动接收普通消息只需要绑定对应消息类别的处理程序，其中普通消息类别对应为：文本消息（text）、图片消息（image）、语音消息（voice）、视频消息（video）、小视频消息（shortvideo）、地理位置消息（location）、链接消息（link），下面代码以文本消息（text）为例：

```php
wechat()->on('text', function($message) {
	return 'Hello Wechat';
});
```

除了上面闭包形式的处理程序，您还可以设置单独的处理类，处理类需要包含`handle`方法。

```php
<?php

namespace App\Wechat\Handlers;

class TextHandler
{
    /**
     * 处理微信发来的文本消息
     *
     * @param  SimpleXMLElement  $message
     * @return void
     */
    public function handle($message)
    {
    	// 处理逻辑
    }
}
```

#### 被动接收事件消息

事件消息与普通消息的处理方式相同，唯一不同的是事件消息的处理程序的键值为**消息类型+事件类型组成**，其中事件消息的类型为`event`，事件类型包含以下几种：关注（subscribe）、取消关注（unsubscribe）、扫描带参数二维码事件（为关注时为subscribe，EventKey以qrscene_为前缀；已关注时为SCAN）、上报地理位置事件（LOCATION）、自定义菜单事件（CLICK）、点击菜单跳转链接时的事件（VIEW），下面以关注事件为例：

```php
wechat()->on('event.subscribe', function($message) {
	return '您已关注。';
});
```
与普通消息一样，除了闭包形式的处理程序外，您仍可以设置单独类作为处理程序，与普通消息一致，这里不再示例。

#### 回复消息的类型

回复消息的类型为微信预定义的几种消息格式，分别为：回复文本消息（text）、回复图片消息（image）、回复语音消息（voice）、回复视频消息（video）、回复音乐消息（music）、回复图文消息（news），当然，SDK中已经对此类的消息做了封装，无需手动生成响应的XML。

```php
Hsinlu\Wechat\Results\TextResult  // 对应文本消息
Hsinlu\Wechat\Results\ImageResult // 对应图片消息
Hsinlu\Wechat\Results\VoiceResult // 对应语音消息
Hsinlu\Wechat\Results\VideoResult // 对应视频消息
Hsinlu\Wechat\Results\MusicResult // 对应音乐消息
Hsinlu\Wechat\Results\NewsResult  // 对应图文消息
```

> 所有的消息结果类都继承抽象类Result，您也可以根据需要扩展消息的类型

所有的消息结果类构造函数接收一个包含消息类所需要的数据数组，以下以回复文本消息为例：

```php

wechat()->on('text', function ($message) {
     return wechat_result(TextResult::class, [
          'fromUserName' => trim($message->ToUserName),
          'toUserName' => trim($message->FromUserName),
          'content' => '这是一条文本消息。',
     ]);
});

```
> SDK中提供了`wechat_result`方法来帮助构建消息结果类，您仍可以使用`new TextResult([])`形式构建。


