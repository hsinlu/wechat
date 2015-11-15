<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

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
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/shorturl', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [
				'action' => 'long2short',
				'long_url' => $long_url,
			],
		]);

		$this->exceptionOrNot($json);

		return $json->short_url;
	}
}