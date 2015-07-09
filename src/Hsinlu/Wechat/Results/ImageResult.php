<?php

namespace Hsinlu\Wechat\Results;

class ImageResult extends Result
{
	public function exec()
	{
		$time = time();
		extract($this->data);

		return "<xml>
				<ToUserName><![CDATA[{$fromUserName}]]></ToUserName>
				<FromUserName><![CDATA[{$toUserName}]]></FromUserName>
				<CreateTime>{$time}</CreateTime>
				<MsgType><![CDATA[image]]></MsgType>
				<Image>
				<MediaId><![CDATA[{$mediaId}]]></MediaId>
				</Image>
				</xml>";	
	}
}