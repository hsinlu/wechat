<?php

namespace Hsinlu\Wechat\Results;

class NewsResult extends Result
{
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