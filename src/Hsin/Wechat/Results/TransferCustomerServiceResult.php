<?php 

namespace Hsin\Wechat\Results;

/**
 * 将消息转发到多客服结果消息
 */
class TransferCustomerServiceResult extends Result
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

		$transInfo = '';
		if (isset($this->data['kfAccount'])) {
			$transInfo= "<TransInfo>
         					<KfAccount><![CDATA[{$kfAccount}]]></KfAccount>
     					</TransInfo>";
		}

		return "<xml>
	                <ToUserName><![CDATA[{$toUserName}]]></ToUserName>
	                <FromUserName><![CDATA[{$fromUserName}]]></FromUserName>
	                <CreateTime>{$time}</CreateTime>
	                <MsgType><![CDATA[transfer_customer_service]]></MsgType>
					{$transInfo}
                </xml>";
	}
}