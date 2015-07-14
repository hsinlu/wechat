<?php

namespace Hsinlu\Wechat\Results;

/**
 * 语音结果消息
 */
class VoiceResult extends Result
{
	/**
	 * 执行并返回微信预定义的XML格式
	 * 
	 * @return string xml
	 */
	public function exec()
	{
		$time = time();
		extract($this->data);

		return "<xml>
					<ToUserName><![CDATA[{$toUserName}]]></ToUserName>
					<FromUserName><![CDATA[{$fromUserName}]]></FromUserName>
					<CreateTime>{$time}</CreateTime>
					<MsgType><![CDATA[voice]]></MsgType>
					<Voice>
						<MediaId><![CDATA[{$mediaId}]]></MediaId>
					</Voice>
				</xml>";
	}
}