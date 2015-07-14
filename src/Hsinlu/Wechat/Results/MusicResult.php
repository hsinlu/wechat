<?php

namespace Hsinlu\Wechat\Results;

/**
 * 音乐结果消息
 */
class MusicResult extends Result
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