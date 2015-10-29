<?php

return [
	// 应用的配置，支持多个应用
	'apps' => [
		// 应用的唯一标识 => 应用配置
		'应用的唯一标识' => [
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
		],
	],
];