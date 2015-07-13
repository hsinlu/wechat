<?php

namespace Hsinlu\Wechat\Foundation;

use Hsinlu\Wechat\WechatException;

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
		$json = http_get([
				'url' => 'https://api.weixin.qq.com/cgi-bin/menu/get',
				'params' => [
					'access_token' => $this->getAccessToken(),
				]
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 创建菜单
	 * 
	 * @return stdClass json
	 */
	public function createMenu($menu)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/menu/create',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => $menu,
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 删除菜单
	 * 
	 * @return stdClass json
	 */
	public function deleteMenu()
	{
		$json = http_get([
				'url' => 'https://api.weixin.qq.com/cgi-bin/menu/delete',
				'params' => [
					'access_token' => $this->getAccessToken(),
				]
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}
}