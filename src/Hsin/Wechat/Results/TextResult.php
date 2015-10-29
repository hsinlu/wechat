<?php 

namespace Hsin\Wechat\Results;

/**
 * 文本结果消息
 */
class TextResult extends Result
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
	                <MsgType><![CDATA[text]]></MsgType>
	                <Content><![CDATA[{$content}]]></Content>
                </xml>";
	}
}