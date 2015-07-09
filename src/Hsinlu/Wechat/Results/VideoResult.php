<?php

namespace Hsinlu\Wechat\Results;

class VideoResult extends Result
{
	public function exec()
	{
		$time = time();
		extract($this->data);

		return "<xml>
				<ToUserName><![CDATA[{$toUserName}]]></ToUserName>
				<FromUserName><![CDATA[{$fromUserName}]]></FromUserName>
				<CreateTime>{$time}</CreateTime>
				<MsgType><![CDATA[video]]></MsgType>
				<Video>
				<MediaId><![CDATA[{$mediaId}]]></MediaId>
				<Title><![CDATA[{$title}]]></Title>
				<Description><![CDATA[{$description}]]></Description>
				</Video> 
				</xml>";
	}
}