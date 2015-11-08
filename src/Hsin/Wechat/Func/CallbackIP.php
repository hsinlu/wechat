<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

/**
 * 微信服务器IP地址
 */
trait CallbackIP
{
	/**
	 * 获取微信服务器IP地址
	 * 
	 * @return array 微信服务器IP地址列表
	 */
	public function getCallbackIP()
	{
		$json = $this->http->getJson('https://api.weixin.qq.com/cgi-bin/getcallbackip', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json->ip_list;
	}
}