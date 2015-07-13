<?php 

namespace Hsinlu\Wechat\Foundation;

use \Closure;
use Illuminate\Support\Facades\Cache;

use Hsinlu\Wechat\WechatException;

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
		return Cache::remember('accessToken' . $this->app_id, 100, function() { 
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
		$json = http_get([
			'url' => 'https://api.weixin.qq.com/cgi-bin/token',
			'params' => [
				'grant_type' => 'client_credential',
				'appid' => $this->app_id,
				'secret' => $this->app_secret,
			]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json->access_token;
	}
}