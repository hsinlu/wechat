![wechat](https://dn-coding-net-production-static.qbox.me/8db6f7ad-8efe-4626-8ccd-f8c7883240d0.png)

# wechat

开发的微信公众平台 SDK，旨在于提供简洁优雅的开发体验。

> 暂不推荐于生产环境

## 功能

以下是所支持的功能列表，根据微信官方文档分类、命名，其中打勾的为已完成功能，其他为开发中状态。

- [x] 微信接入
- [x] 获取access_token
- [x] 获取微信服务器IP地址
- [x] 被动接收普通消息
- [x] 被动接收事件消息
- [x] 被动回复消息
- [x] 客服消息(接口调用不成功)
- [ ] 多客服功能(接口调用不成功)
- [x] 群发消息
- [x] 模板消息(未测试)
- [x] 获取自动回复规则
- [ ] 消息加解密
- [x] 素材管理(添加永久素材，视频素材没实现)
- [x] 用户管理
- [x] 自定义菜单管理
- [x] 二维码
- [x] 长链接转短链接
- [x] 数据统计
- [x] 语义理解
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

## 注意事项
1. 所有发往微信的json数据，如果包含中文，在使用`json_encode`时，需要设置`JSON_UNESCAPED_UNICODE`

```php

json_encode(['group' => [ 'id' => $groupid, 'name' => '我的家人' ],], JSON_UNESCAPED_UNICODE);

```

## 安装
##### 使用composer安装
```bash
composer require "hsinlu/wechat"
```

## 使用

### 配置

在实例化类时传入微信相关的配置。

```php
<?php

// 一下内容中的$app均是`Hsin\Wechat\Application`对象
$app = new Hsin\Wechat\Application([
  // 应用ID
    'app_id' => '应用ID',
    // 应用密钥
    'app_secret' => '应用密钥',
    // 令牌
    'token' => '令牌',
    // 消息是否加密 
    'encrypt' => false,
    // 消息加解密密钥
    'encoding_AES_key' => '消息加解密密钥',
]);

```

### 被动接收消息

#### 被动接收普通消息

被动接收普通消息只需要绑定对应消息类别的处理程序，其中普通消息类别对应为：文本消息（text）、图片消息（image）、语音消息（voice）、视频消息（video）、小视频消息（shortvideo）、地理位置消息（location）、链接消息（link），下面代码以文本消息（text）为例：

```php
$app->on('text', function($message) {
	return 'Hello Wechat';
});
```

除了上面闭包形式的处理程序，您还可以设置单独的处理类，处理类需要包含 `handle` 方法。

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
$app->on('event.subscribe', function($message) {
	return '您已关注。';
});
```
与普通消息一样，除了闭包形式的处理程序外，您仍可以设置单独类作为处理程序，与普通消息一致，这里不再示例。

#### 回复消息的类型

回复消息的类型为微信预定义的几种消息格式，分别为：回复文本消息（text）、回复图片消息（image）、回复语音消息（voice）、回复视频消息（video）、回复音乐消息（music）、回复图文消息（news），当然，SDK中已经对此类的消息做了封装，无需手动生成响应的XML。

```php
Hsin\Wechat\Results\TextResult  // 对应文本消息
Hsin\Wechat\Results\ImageResult // 对应图片消息
Hsin\Wechat\Results\VoiceResult // 对应语音消息
Hsin\Wechat\Results\VideoResult // 对应视频消息
Hsin\Wechat\Results\MusicResult // 对应音乐消息
Hsin\Wechat\Results\NewsResult  // 对应图文消息
```

> 所有的消息结果类都继承抽象类Result，您也可以根据需要扩展消息的类型

所有的消息结果类构造函数接收一个包含消息类所需要的数据数组，以下以回复文本消息为例：

```php

$app->on('text', function ($message) {
     return new TextResult([
          'fromUserName' => trim($message->ToUserName),
          'toUserName' => trim($message->FromUserName),
          'content' => '这是一条文本消息。',
     ]);
});

```

### 调用微信接口

#### 获取access token

`getAccessToken()`

`getAccessToken`方法会优先从缓存中获取**access token**，缓存时间为100分钟，如果检测到缓存中不存在**access token**或者缓存过期，将会从微信服务器中重新获取。

```php
// 返回access token
$app->getAccessToken();
```
</br>

`forgetAccessToken()`

该方法会移除缓存中的**access token**，下次获取**access token**将从微信服务器中重新获取。

```php
// 移除缓存中的access token
$app->forgetAccessToken();
```

#### 获取微信服务器IP地址

`getCallbackIP()`

`getCallbackIP`方法获取微信服务器IP地址列表。

```php
// 获取微信服务器IP地址列表
$app->getCallbackIP();

// {
//		"ip_list":["127.0.0.1","127.0.0.1"]
// }
```

#### 客服消息

`addKFAccount()`

`addKFAccount`方法用于添加客服账号。

```php
// 添加客服账号
// $account => 'test1@test'
// $nickname => '客服1'
// $password => 'pswmd5'
$app->addKFAccount($account, $nickname, $password);

// bool 是否添加成功
```
<br />

`modifyKFAccount()`

`modifyKFAccount`方法用于修改客服账号

```php
// 修改客服账号
// $account => 'test1@test'
// $nickname => '客服1'
// $password => 'pswmd5'
$app->modifyKFAccount($account, $nickname, $password);

// bool 是否修改成功
```
<br />

`deleteKFAccount()`

`deleteKFAccount`方法用于删除客服账号

```php
// 删除客服账号
// $account => 'test1@test'
// $nickname => '客服1'
// $password => 'pswmd5'
$app->deleteKFAccount($account, $nickname, $password);

// bool 是否删除成功
```
<br />

`uploadKFAccountAvatar()`

`uploadKFAccountAvatar`方法用于设置客服账号的头像

```php
// 设置客服帐号的头像
// $account => 'test1@test'
// $avatar => '头像文件'
$app->uploadKFAccountAvatar($account, $avatar);

// bool 是否设置成功
```
<br />

`getAllKFAccount()`

`getAllKFAccount`用于获取所有客服账号

```php
// 获取所有客服账号
// $account => 'test1@test'
// $avatar => '头像文件'
$app->getAllKFAccount();

/*
{
    "kf_list": [
        {
            "kf_account": "test1@test", 
            "kf_nick": "ntest1", 
            "kf_id": "1001"
            "kf_headimgurl": " http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjfUS8Ym0GSaLic0FD3vN0V8PILcibEGb2fPfEOmw/0"
        }, 
        {
            "kf_account": "test2@test", 
            "kf_nick": "ntest2", 
            "kf_id": "1002"
            "kf_headimgurl": " http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjfUS8Ym0GSaLic0FD3vN0V8PILcibEGb2fPfEOmw /0"
        }, 
        {
            "kf_account": "test3@test", 
            "kf_nick": "ntest3", 
            "kf_id": "1003"
            "kf_headimgurl": " http://mmbiz.qpic.cn/mmbiz/4whpV1VZl2iccsvYbHvnphkyGtnvjfUS8Ym0GSaLic0FD3vN0V8PILcibEGb2fPfEOmw /0"
        }
    ]
}
*/
```
<br />

`sendKFMessage()`

`sendKFMessage`用于发送客服消息

```php
// 发送客服消息
/* $message => '{
    		"touser":"OPENID",
    		"msgtype":"text",
    		"text":
    		{
         		"content":"Hello World"
    		}
	}'
	
	$message可以为json字符串、json对象、数组，为对象或数组时会自动转化为json字符串。
*/
// 具体参见：http://mp.weixin.qq.com/wiki/1/70a29afed17f56d537c833f89be979c9.html
$app->sendKFMessage($message);

// bool 是否发送成功
```
#### 群发消息

`uploadNews()`

`uploadNews`方法用于上传图文消息素材

```php
/*
$articles = '{
   "articles": [
		 {
          "thumb_media_id":"qI6_Ze_6PtV7svjolgs-rN6stStuHIjs9_DidOHaj0Q-mwvBelOXCFZiq2OsIU-p",
          "author":"xxx",
			  "title":"Happy Day",
			  "content_source_url":"www.qq.com",
			  "content":"content",
			  "digest":"digest",
          "show_cover_pic":"1"
		 },
		 {
         "thumb_media_id":"qI6_Ze_6PtV7svjolgs-rN6stStuHIjs9_DidOHaj0Q-mwvBelOXCFZiq2OsIU-p",
         "author":"xxx",
			 "title":"Happy Day",
			 "content_source_url":"www.qq.com",
			 "content":"content",
			 "digest":"digest",
         "show_cover_pic":"0"
		 }
   ]
}'

$articles可以为json字符串、json对象、数组，为对象或数组时会自动转化为json字符串。
*/
$app->uploadNews($articles);

/*
{
   "type":"news",
   "media_id":"CsEf3ldqkAYJAU6EJeIkStVDSvffUJ54vqbThMgplD-VJXXof6ctX5fI6-aYyUiQ",
   "created_at":1391857799
}
*/
```
<br />

`massSendByGroup()`

`massSendByGroup`方法用于给分组群发消息。

```php
/*
$message = '{
   "filter":{
      "is_to_all":false
      "group_id":"2"
   },
   "text":{
      "content":"CONTENT"
   },
    "msgtype":"text"
}'

$message可以为json字符串、json对象、数组，为对象或数组时会自动转化为json字符串。
*/
// 具体参见：http://mp.weixin.qq.com/wiki/15/5380a4e6f02f2ffdc7981a8ed7a40753.html

$app->massSendByGroup($message);

/*
{
   "errcode":0,
   "errmsg":"send job submission success",
   "msg_id":34182
}
*/
```


