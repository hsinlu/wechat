<?php

namespace Hsin\Wechat\Func;

use Illuminate\Support\Facades\Cache;

use Hsin\Wechat\WechatException;

/**
 * 用户管理
 */
trait OAuth2
{
	public function getOpenidByOAuth2Code($code)
	{
		$json = http()->get('https://api.weixin.qq.com/sns/oauth2/access_token', [
			'query' => [
				'appid' => $this->appId,
				'secret' => $this->appSecret,
				'code' => $code,
				'grant_type' => 'authorization_code'
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		$this->cacheOAuth2Info($json);

		return $json->openid;
	}

	public function refreshOAuth2AccessToken($openid)
	{
		$oauth2 = $this->getOAuth2InfoFromCache($openid);

		$json = http()->get('https://api.weixin.qq.com/sns/oauth2/refresh_token', [
			'query' => [
				'appid' => $this->appId,
				'grant_type' => 'refresh_token',
				'refresh_token' => $oauth2->refresh_token,
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		$this->cacheOAuth2Info($json);

		return $json->access_token;
	}

	public function getUserInfoByOAuth2($openid, $lang = 'zh-CN')
	{
		$oauth2 = $this->getOAuth2InfoFromCache($openid);

		$json = http()->get('https://api.weixin.qq.com/sns/userinfo', [
			'query' => [
				'access_token' => $oauth2->access_token,
				'openid' => $openid,
				'lang' => $lang,
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	public function isOAuth2AccessTokenAlive($openid)
	{
		$oauth2 = $this->getOAuth2InfoFromCache($openid);

		$json = http()->get('https://api.weixin.qq.com/sns/auth', [
			'query' => [
				'access_token' => $oauth2->access_token,
				'openid' => $openid,
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	private function cacheOAuth2Info($oauth2)
	{
		return Cache::forever('OAuth2'.$oauth2->openid, $oauth2);
	}

	public function getOAuth2InfoFromCache($openid)
	{
		return Cache::get('OAuth2'.$openid);
	}
}