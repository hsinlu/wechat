<?php

namespace Hsinlu\Wechat\Results;

class MusicResult extends Result
{
	public function exec()
	{
		$time = time();
    	extract($this->data);

		return "<xml>
                <ToUserName><![CDATA[{$toUserName}]]></ToUserName>
                <FromUserName><![CDATA[{$fromUserName}]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[music]]></MsgType>
                <Music>
                <Title><![CDATA[$title]]></Title>
                <Description><![CDATA[{$description}]]></Description>
                <MusicUrl><![CDATA[{$musicUrl}]]></MusicUrl>
                <HQMusicUrl><![CDATA[{$HQMusicUrl}]]></HQMusicUrl>
                <ThumbMediaId><![CDATA[{$thumbMediaId}]]></ThumbMediaId>
                </Music>
                </xml>";
	}
}