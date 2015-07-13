<?php

if (!function_exists('wechat')) {
	/**
	 * 获取微信应用实例
	 * 
	 * @param  string 			 $uniqid 应用唯一标识
	 * @return Hsinlu\Wechat\App         应用
	 */
	function wechat($uniqid = null)
	{
		return app('wechat')->app($uniqid);
	}
}

if (!function_exists('wechat_config')) {
	/**
	 * 获取微信应用的配置
	 * @param  string $uniqid 应用唯一标识
	 * @return array          配置
	 */
	function wechat_config($uniqid = null)
	{
		if (is_null($uniqid)) {
			return current(config('wechat.apps'));
		}

		return config('wechat.apps')[$uniqid];
	}
}

if (!function_exists('wechat_result')) {
	/**
	 *	生成微信返回的结果
	 * 
	 * @param  Hsinlu\Wechat\Results\Result $make 结果类
	 * @param  array  						$data 返回的数据
	 * @return Hsinlu\Wechat\Results\Result       
	 */
	function wechat_result($make, array $data)
	{
		return new $make($data);
	}
}
