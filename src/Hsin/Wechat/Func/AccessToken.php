<?php 

namespace Hsin\Wechat\Func;

use \Closure;

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
		return $this->cache->remember('accessToken'.$this->appId, function() { 
			return $this->getAccessTokenFromServer();
		}, 100);
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

		$this->exceptionOrNot($json);

		return $json->access_token;
	}

	/**
	 * 从缓存中移除AccessToken
	 */
	public function forgetAccessToken()
	{
		$this->cache->forget('accessToken'.$this->appId);
	}
}
