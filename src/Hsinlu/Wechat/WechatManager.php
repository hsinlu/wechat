<?php

namespace Hsinlu\Wechat;

class WechatManager
{
	/**
	 * 应用数组
	 * 
	 * @var array
	 */
	protected $apps = [];

	/**
	 * 根据uniqid获取应用
	 * 
	 * @param  string $uniqid 			应用唯一标识
	 * @return Hsinlu\Wechat\App        应用
	 */
	public function app($uniqid = null)
	{
		$uniqid = $uniqid ?: $this->getDefaultAppUniqid();

		if (isset($this->apps[$uniqid])) {
			return $this->apps[$uniqid];
		}

		$app = $this->makeApp($uniqid);
		
		$this->apps[$uniqid] = $app;

		return $app;
	}


	protected function makeApp($uniqid)
	{
		return new App(wechat_config($uniqid));
	}

	protected function getDefaultAppUniqid()
	{
		return current(array_keys(config('wechat.apps')));
	}

    /**
     * 动态执行应用的方法
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->wechat, $method], $parameters);
    }
}