<?php 

namespace Hsin\Wechat\Func;

use \Closure;
use Illuminate\Support\Facades\Cache;

use Hsin\Wechat\WechatException;

/**
 * AccessToken
 */
trait AccessToken
{
	/**
	 * 获取AccessToken
	 * 
	 * @return  string AccessToken
	 */
	public function getAccessToken()
	{
		return Cache::remember('accessToken'.$this->appId, 100, function() { 
			return $this->getAccessTokenFromServer();
		});
	}

	/**
	 * 从微信服务器中获取AccessToken
	 * 
	 * @return string access token
	 */
	protected function getAccessTokenFromServer()
	{
		$json = $this->http->getJson('https://api.weixin.qq.com/cgi-bin/token', [
			'query' => [
				'grant_type' => 'client_credential',
				'appid' => $this->appId,
				'secret' => $this->appSecret,
			]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json->access_token;
	}

	/**
	 * 从缓存中移除AccessToken
	 */
	public function forgetAccessToken()
	{
		Cache::forget('accessToken');
	}
}
