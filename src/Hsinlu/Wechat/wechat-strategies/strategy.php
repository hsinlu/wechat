<?php

use Hsinlu\Wechat\Results\TextResult;

$app->on('text', function ($message) {
	return wechat_result(TextResult::class, [
        'fromUserName' => trim($message->ToUserName),
        'toUserName' => trim($message->FromUserName),
        'content' => 'hello wechat.',
    ]);
});