<?php 

namespace Hsinlu\Wechat\Results;

class TextResult extends Result
{
	public function exec()
	{
		$time = time();
		extract($this->data);

		return "<xml>
                <ToUserName><![CDATA[{$toUserName}]]></ToUserName>
                <FromUserName><![CDATA[{$fromUserName}]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[{$content}]]></Content>
                </xml>";
	}
}