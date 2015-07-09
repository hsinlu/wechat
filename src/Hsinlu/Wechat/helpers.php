<?php

use Illuminate\Support\Facades\App;

if (!function_exists('wechat')) {
	function wechat($uniqid = null)
	{
		return app('wechat')->app($uniqid);
	}
}

if (!function_exists('wechat_config')) {
	function wechat_config($uniqid = null)
	{
		if (is_null($uniqid)) {
			return current(config('wechat.apps'));
		}

		return config('wechat.apps')[$uniqid];
	}
}
