<?php
namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

/**
 * 用户组管理
 */
trait GroupManager
{
	/**
	 * 创建分组
	 * 
	 * @param  string $name 分组名称
	 * @return stdClass       json
	 */
	public function createGroup($name)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/groups/create', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'body' => json_encode(['group' => [ 'name' => $name ],], JSON_UNESCAPED_UNICODE),
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取所有分组
	 * 
	 * @return stdClass 所有分组
	 */
	public function getAllGroups()
	{
		$json = $this->http->getJson('https://api.weixin.qq.com/cgi-bin/groups/get', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 根据openid获取所在的用户组
	 * 
	 * @param  string $openid 用户openid
	 * @return int       	  用户分组id
	 */
	public function getGroupIdByOpenId($openid)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/groups/getid', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => ['openid' => $openid, ], 
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json->groupid;
	}

	/**
	 * 修改分组名
	 * 
	 * @param  string $groupid 分组的id
	 * @param  string $name    分组的名称
	 * @return bool            是否修改成功
	 */
	public function updateGroupName($groupid, $name)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/groups/update', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'body' => json_encode(['group' => [ 'id' => $groupid, 'name' => $name ],], JSON_UNESCAPED_UNICODE),
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 删除分组
	 * 
	 * @param  string $groupid 分组id
	 * @return bool        		是否删除成功
	 */
	public function deleteGroup($groupid)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/groups/delete', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [
				'group' => [ 'id' => $groupid ],
			],
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 移动用户分组
	 * 
	 * @param  string or array $openid  用户openid或用户openid数组
	 * @param  string $groupid          分组id
	 * @return bool                     是否移动成功
	 */
	public function moveToGroup($openid, $groupid)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/groups/members/update';
		$data = [ 'to_groupid' => $groupid ];

		if (is_array($openid)) {
			$url = 'https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate';
			$data['openid_list'] = $openid;
		} else {
			$data['openid'] = $openid;
		}

		$json = $this->http->postJson($url, [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => $data,
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}
}