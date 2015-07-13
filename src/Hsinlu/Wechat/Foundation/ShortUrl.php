<?php

namespace Hsinlu\Wechat\Foundation;

use Hsinlu\Wechat\WechatException;

/**
 * 短Url地址
 */
trait ShortUrl
{
	/**
	 * 生成短Url地址
	 * 
	 * @param  string $long_url 需要转换的长地址
	 * @return string           转换后的短地址
	 */
	public function shortUrl($long_url)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/shorturl',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => json_encode([
					'action' => 'long2short',
					'long_url' => $long_url,
				]),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json->short_url;
	}
}