<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

/**
 * 语义理解
 */
trait Semantic
{
	/**
	 * 语义理解查找
	 * 
	 * @param  array $context 查找的上下文
	 * @return [type]       [description]
	 */
	public function semanticSearch(array $context)
	{
		$context['appid'] = $this->appId;

		$json = $this->http->postJson('https://api.weixin.qq.com/semantic/semproxy/search', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => $context,
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}
}