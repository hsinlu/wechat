<?php

namespace Hsinlu\Wechat\Results;

class VoiceResult extends Result
{
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