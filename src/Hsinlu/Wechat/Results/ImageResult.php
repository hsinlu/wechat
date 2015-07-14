<?php

namespace Hsinlu\Wechat\Results;

/**
 * 图片结果消息
 */
class ImageResult extends Result
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