<?php

namespace Hsin\Wechat\Func;

trait Exception
{
	/**
	 * 检查时否异常
	 * 
	 * @param  [type] $json [description]
	 * @return [type]       [description]
	 */
	public function exceptionOrNot($returned)
	{
		if (property_exists($returned, 'errcode') && $returned->errcode != 0) {
			throw new WechatException($returned->errmsg, $returned->errcode);
		}
	}
}