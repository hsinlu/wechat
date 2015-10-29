<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

/**
 * 二维码
 */
trait QRCode
{
	/**
	 * 创建临时二维码ticket
	 * 
	 * @param  mixed $qr_scene 二维码情景
	 * @return stdClass        json
	 */
	public function createTempQRCodeTicket($qr_scene)
	{
		return $this->createQRCodeTicket($qr_scene);
	}

	/**
	 * 创建永久二维码ticket
	 * 
	 * @param  mixed $qr_scene 二维码情景
	 * @return stdClass        json
	 */
	public function createForeverQRCodeTicket($qr_scene)
	{
		return $this->createQRCodeTicket($qr_scene);
	}

	/**
	 * 创建二维码ticket
	 * 
	 * @param  mixed $qr_scene 二维码情景
	 * @return stdClass        json
	 */
	protected function createQRCodeTicket($qr_scene)
	{
		$json = http()->post('https://api.weixin.qq.com/cgi-bin/qrcode/create', [ 
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'body' => is_string($qr_scene) ? $qr_scene : json_encode($qr_scene),
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 通过ticket换取二维码
	 *
	 * @param sting $ticket 二维码ticket
	 * @return stdClass 
	 */
	public function exchangeQRCode($ticket)
	{
		$response = http()->get('https://mp.weixin.qq.com/cgi-bin/showqrcode', [
			'query' => [
				'ticket' => $ticket,
			]
		])->response();

		$json = $response->json();
		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $response->headers();
	}
}