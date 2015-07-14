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