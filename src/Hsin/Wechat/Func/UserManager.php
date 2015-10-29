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
		$json = http()->get('https://api.weixin.qq.com/cgi-bin/user/get', [
			'query' => [
				'access_token' => $this->getAccessToken(),
				'next_openid' => $next_openid,
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

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
		$json = http()->get('https://api.weixin.qq.com/cgi-bin/user/info', [
			'query' => [
				'access_token' => $this->getAccessToken(),
				'openid' => $openid,
				'lang' => $lang,
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

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
		$json = http()->post('https://api.weixin.qq.com/cgi-bin/user/info/batchget', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'user_list' => $openids ]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

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
		$json = http()->post('https://api.weixin.qq.com/cgi-bin/user/info/updateremark', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [
				'openid' => $openid,
				'remark' => $remark,
			],
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}
}