<?php

namespace Hsinlu\Wechat\Foundation;

use Hsinlu\Wechat\WechatException;

/**
 * 模板消息
 */
trait Template
{
	/**
	 * 设置所属行业
	 * 
	 * @param int $industry_id1 行业1
	 * @param int $industry_id2 行业2
	 * @return stdClass 	    json
	 */
	public function setIndustry($industry_id1, $industry_id2)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => json_encode([
					'industry_id1' => $industry_id1,
					'industry_id2' => $industry_id2,
				]),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获得模板ID
	 *
	 * @param string $template_id_short 模板库中模板的编号，有“TM**”和“OPENTMTM**”等形式
	 * @return string  				    模板ID
	 */
	public function getTemplateID($template_id_short)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/template/api_add_template',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => json_encode([
					'template_id_short' => $template_id_short,
				]),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json->template_id;
	}

	/**
	 * 发送模板消息
	 * 
	 * @param  string $message 模板消息
	 * @return stdClass        json
	 */
	public function sendTemplateMessage($message)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/message/template/send',
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
}