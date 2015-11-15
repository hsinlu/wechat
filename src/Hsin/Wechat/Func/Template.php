<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

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
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/template/api_set_industry', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [
				'industry_id1' => $industry_id1,
				'industry_id2' => $industry_id2,
			],
		]);

		$this->exceptionOrNot($json);

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
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/template/api_add_template',[
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [
				'template_id_short' => $template_id_short,
			],
		]);

		$this->exceptionOrNot($json);

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
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/message/template/send', [
			'params' => [
				'access_token' => $this->getAccessToken(),
			],
			'body' => is_string($message) ? $message : json_encode($message, JSON_UNESCAPED_UNICODE),
		]);

		$this->exceptionOrNot($json);

		return $json;
	}
}