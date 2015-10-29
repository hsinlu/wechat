<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

/**
 * 菜单管理
 */
trait Menu
{
	/**
	 * 获取菜单
	 * 
	 * @return stdClass json
	 */
	public function getMenu()
	{
		$json = http()->get('https://api.weixin.qq.com/cgi-bin/menu/get', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取任何方式创建的菜单
	 * 
	 * @return stdClass json
	 */
	public function getMenuAnyWay()
	{
		$json = http()->get('https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}
	
	/**
	 * 创建菜单
	 * 
	 * @param  string or array $menu  菜单数据
	 * @return bool                   是否创建成功
	 */
	public function createMenu($menu)
	{
		$json = http()->post('https://api.weixin.qq.com/cgi-bin/menu/create', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'body' => is_string($menu) ? $menu : json_encode($menu),
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 删除菜单
	 * 
	 * @return bool 是否删除成功
	 */
	public function deleteMenu()
	{
		$json = http()->get('https://api.weixin.qq.com/cgi-bin/menu/delete', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			]
		])->json();

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}
}