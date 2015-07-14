<?php

namespace Hsinlu\Wechat\Results;

/**
 * 图文结果消息
 */
class NewsResult extends Result
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

		$itemsCount = count($items);
        foreach ($items as $item) {
        	extract($item)
            $item_str .= "<item>
    	                    <Title><![CDATA[{$title}]]></Title>
    	                    <Description><![CDATA[{$description}]]></Description>
    	                    <PicUrl><![CDATA[{$picUrl}]]></PicUrl>
    	                    <Url><![CDATA[{$url}]]></Url>
	                     </item>";
        }
            
        return "<xml>
                    <ToUserName><![CDATA[{$toUserName}]]></ToUserName>
                    <FromUserName><![CDATA[{$fromUserName}]]></FromUserName>
                    <CreateTime>{$time}</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>{$itemsCount}</ArticleCount>
                    <Articles>{$item_str}</Articles>
                </xml>";
	}
}