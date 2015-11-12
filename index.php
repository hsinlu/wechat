<?php

require 'vendor/autoload.php';

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

$app->on('text', function ($message) {
	return new TextResult([
        'fromUserName' => trim($message->ToUserName),
        'toUserName' => trim($message->FromUserName),
        'content' => 'hello wechat.',
    ]);
});

$app->on('event.subscribe', function ($message) {
	return new TextResult([
        'fromUserName' => trim($message->ToUserName),
        'toUserName' => trim($message->FromUserName),
        'content' => '欢迎关注~',
    ]);
});

$signature = $_GET["signature"];
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];

if ($app->checkSignature($signature, $timestamp, $nonce)) {
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		return $_GET['echostr'];
	} else {
		$message = $GLOBALS["HTTP_RAW_POST_DATA"];
		$message = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);

        echo $app->handle($message);
	}
}

