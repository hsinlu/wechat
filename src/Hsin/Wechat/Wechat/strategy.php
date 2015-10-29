<?php

use Hsin\Wechat\Results\TextResult;

wechat()->on('text', function ($message) {
	return wechat_result(TextResult::class, [
        'fromUserName' => trim($message->ToUserName),
        'toUserName' => trim($message->FromUserName),
        'content' => 'hello wechat.',
    ]);
});

// wechat('wx...')->on('text', function ($message) {
// 	return wechat_result(TextResult::class, [
//         'fromUserName' => trim($message->ToUserName),
//         'toUserName' => trim($message->FromUserName),
//         'content' => 'hello wechat.',
//     ]);
// });