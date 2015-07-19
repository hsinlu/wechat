<?php

namespace Hsinlu\Wechat\Foundation;

use Hsinlu\Wechat\WechatException;

/**
 * 自动回复规则
 */
trait AutoReplyRule
{
	/**
	 * 获取自动回复规则
	 * 
	 * @return stdClass json
	 */
	public function getAutoReplyRule()
	{
		$json = http_get([
			'url' => 'https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info',
			'params' => [
				'access_token' => $this->getAccessToken(),
			]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}
}