<?php 

namespace Hsin\Wechat\Func;

use \Closure;

/**
 * Access
 */
trait Access
{
	/**
	 * 校验微信签名
	 * 
	 * @param  string $signature signature
	 * @param  string $timestamp timestamp
	 * @param  string $nonce     nonce
	 * @return boolean           是否验证通过
	 */
    public function checkSignature($signature, $timestamp, $nonce)
    {
        $tmpArr = array($this->token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        return $tmpStr == $signature;
    }
}