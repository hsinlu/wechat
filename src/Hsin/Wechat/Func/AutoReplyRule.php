<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

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
		$json = http()->get('https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}
}