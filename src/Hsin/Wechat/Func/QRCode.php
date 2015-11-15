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
	 * @param int $scene_id       场景值ID，临时二维码时为32位非0整型
	 * @param int $expire_seconds 该二维码有效时间，以秒为单位。 最大不超过604800（即7天）
	 * @return stdClass           json
	 */
	public function createTempQRCodeTicket($scene_id, $expire_seconds = 604800)
	{
		$qr_scene = [
			'expire_seconds' => $expire_seconds,
			'action_name' => 'QR_SCENE',
			'action_info' => [ 'scene' => [ 'scene_id'=> $scene_id ] ]
		];

		return $this->createQRCodeTicket($qr_scene);
	}

	/**
	 * 创建永久二维码ticket
	 * 
	 * @param  int $scene_id 场景值ID，永久二维码时最大值为100000（目前参数只支持1--100000）
	 * @return stdClass        json
	 */
	public function createForeverQRCodeTicket($scene_id)
	{
		$qr_scene = [
			'action_name' => 'QR_LIMIT_SCENE',
			'action_info' => [ 'scene' => [ 'scene_id'=> $scene_id ] ]
		];

		return $this->createQRCodeTicket($qr_scene);
	}

	/**
	 * 创建永久二维码ticket
	 * 
	 * @param  int $scene_str 场景值ID（字符串形式的ID），字符串类型，长度限制为1到64，仅永久二维码支持此字段
	 * @return stdClass        json
	 */
	public function createForeverQRCodeTicketUseStr($scene_str)
	{
		$qr_scene = [
			'action_name' => 'QR_LIMIT_STR_SCENE',
			'action_info' => [ 'scene' => [ 'scene_str'=> $scene_str ] ]
		];

		return $this->createQRCodeTicket($qr_scene);
	}

	/**
	 * 创建二维码ticket
	 * 
	 * @param  array $qr_scene 二维码情景
	 * @return stdClass        json
	 */
	protected function createQRCodeTicket($qr_scene)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/qrcode/create', [ 
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => $qr_scene,
		]);

		$this->exceptionOrNot($json);

		return $json;
	}

	/**
	 * 通过ticket换取二维码
	 *
	 * @param sting $ticket 二维码ticket
	 * @param string $savePath 二维码存储路径
	 * @return mixed 
	 */
	public function exchangeQRCode($ticket, $savePath = false)
	{
		$content = $this->http->get('https://mp.weixin.qq.com/cgi-bin/showqrcode', [
			'query' => [
				'ticket' => $ticket
			]
		])->content();

		if (! $savePath) return $content;

		$fp = fopen($savePath, 'w');
		if ($fp) {
			fwrite($fp, $content);
			fclose($fp);
		}
	}
}