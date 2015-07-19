<?php

namespace Hsinlu\Wechat\Foundation;

use Hsinlu\Wechat\WechatException;

/**
 * 群发消息
 */
trait MassSend
{
	/**
	 * 上传图文消息素材【订阅号与服务号认证后均可用】
	 * 
	 * @param  string or array $articles 图文消息
	 * @return stdClass           		 json
	 */
	public function uploadNews($articles)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/media/uploadnews',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => is_string($articles) ? $articles : json_encode($articles),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 根据分组进行群发【订阅号与服务号认证后均可用】
	 *
	 * @param string or object $message 群发的消息
	 * @return stdClass 				json
	 */
	public function massSendByGroup($message)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => is_string($message) ? $message : json_encode($message),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 根据OpenID列表群发【订阅号不可用，服务号认证后可用】
	 * 
	 * @param  string or array $message 群发的消息
	 * @return bool          			是否发送成功
	 */
	public function massSendByOpenIDList($message)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/message/mass/send',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => is_string($message) ? $message : json_encode($message),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 删除群发【订阅号与服务号认证后均可用】
	 * 
	 * @param  int $msg_id 消息id
	 * @return bool        是否删除成功
	 */
	public function deleteMassSend($msg_id)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/message/mass/delete',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => json_encode(['msg_id' => $msg_id]),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 预览接口【订阅号与服务号认证后均可用】
	 * 
	 * @param  string or stdClass $message 要预览的群发消息
	 * @return bool                        是否发送成功
	 */	
	public function previewMassSend($message)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/message/mass/preview',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => is_string($message) ? $message : json_encode($message),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 查询群发消息发送状态【订阅号与服务号认证后均可用】
	 * 
	 * @param  int $msg_id 群发消息id
	 * @return stdClass    json
	 */
	public function getMassSendStatus($msg_id)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/message/mass/get',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => json_encode(['msg_id' => $msg_id]),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}
}