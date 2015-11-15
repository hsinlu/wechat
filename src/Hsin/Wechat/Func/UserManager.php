<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

/**
 * 用户管理
 */
trait UserManager
{
	/**
	 * 获取用户列表
	 * 
	 * @param  string $next_openid 下一个openid
	 * @return stdClass				json              
	 */
	public function getUserList($next_openid = '')
	{
		$json = $this->http->getJson('https://api.weixin.qq.com/cgi-bin/user/get', [
			'query' => [
				'access_token' => $this->getAccessToken(),
				'next_openid' => $next_openid,
			]
		]);

		$this->exceptionOrNot($json);

		return $json;
	}

	/**
	 * 获取用户信息
	 * 
	 * @param  string $openid 用户openid
	 * @param  string $lang   返回国家地区语言版本
	 * @return stdClass       json
	 */
	public function getUserInfo($openid, $lang = 'zh-CN')
	{
		$json = $this->http->getJson('https://api.weixin.qq.com/cgi-bin/user/info', [
			'query' => [
				'access_token' => $this->getAccessToken(),
				'openid' => $openid,
				'lang' => $lang,
			]
		]);

		$this->exceptionOrNot($json);

		return $json;
	}

	/**
	 * 批量获取用户信息
	 * 
	 * @param  array $openids 要获取的用户列表
	 * @return stdClass       json
	 */
	public function batchGetUserInfo($openids)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/user/info/batchget', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'user_list' => $openids ]
		]);

		$this->exceptionOrNot($json);

		return $json;
	}

	/**
	 * 更新用户备注信息
	 * @param  string $openid open id
	 * @param  string $remark 备注信息
	 * @return bool           是否成功
	 */
	public function updateUserRemark($openid, $remark)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/user/info/updateremark', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'body' => json_encode([ 'openid' => $openid, 'remark' => $remark, ], JSON_UNESCAPED_UNICODE)
		]);

		$this->exceptionOrNot($json);

		return true;
	}
}