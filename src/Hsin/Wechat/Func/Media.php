<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

/**
 * 素材管理
 */
trait Media
{
	/**
	 * 上传临时素材
	 * 
	 * @param  string $type 素材类型（图片（image）、语音（voice）、视频（video）和缩略图（thumb））
	 * @param  File $file 	上传的素材
	 * @return stdClass     json
	 */
	public function uploadMedia($type, $file)
	{
		$json = http()->post('https://api.weixin.qq.com/cgi-bin/media/upload', [
			'query' => [
				'access_token' => $this->getAccessToken(),
				'type' => $type,
			],
			'body' => $file,
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取临时素材
	 * @param string $media_id 临时素材id
	 * @return mixed 
	 */
	public function GetMedia($media_id)
	{
		$response = http()->get('https://api.weixin.qq.com/cgi-bin/media/get', [
			'query' => [
				'access_token' => $this->getAccessToken(),
				'media_id' => $media_id,
			]
		])->response();

		$json = $response->json();
		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $response->headers();
	}

	/**
	 * 获取素材列表
	 * 
	 * @param  string $type   素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
	 * @param  int 	  $offset 从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
	 * @param  int    $count  返回素材的数量，取值在1到20之间
	 * @return stdClass       json
	 */
	public function getMaterialList($type, $offset = 0, $count = 20)
	{
		$json = http()->post('https://api.weixin.qq.com/cgi-bin/material/batchget_material', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [
				'type' => $type,
				'offset' => $offset,
				'count' => $count,
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取素材总数
	 * 
	 * @return stdClass json
	 */
	public function getMaterialCount()
	{
		$json = http()->get('https://api.weixin.qq.com/cgi-bin/material/get_materialcount', [
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