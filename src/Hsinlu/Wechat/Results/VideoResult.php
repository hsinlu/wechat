<?php

namespace Hsinlu\Wechat\Results;

/**
 * 视频结果消息
 */
class VideoResult extends Result
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
					<MsgType><![CDATA[video]]></MsgType>
					<Video>
						<MediaId><![CDATA[{$mediaId}]]></MediaId>
						<Title><![CDATA[{$title}]]></Title>
						<Description><![CDATA[{$description}]]></Description>
					</Video> 
				</xml>";
	}
}