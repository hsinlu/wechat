<?php

namespace Hsinlu\Wechat\Foundation;

use Hsinlu\Wechat\WechatException;

/**
 * 客服接口
 */
trait CustomerService
{
	/**
	 * 添加客服账号
	 * 
	 * @param string $account  账号
	 * @param string $nickname 昵称
	 * @param string $password 密码
	 * @return bool 		   是否添加成功
	 */
	public function addKFAccount($account, $nickname, $password)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/customservice/kfaccount/add',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => json_encode([
					'kf_account' => $account,
					'nickname' => $nickname,
					'password' => $password,
				]),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 修改客服帐号
	 * 
	 * @param string $account  账号
	 * @param string $nickname 昵称
	 * @param string $password 密码
	 * @return bool 		   是否修改成功
	 */
	public function modifyKFAccount($account, $nickname, $password)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/customservice/kfaccount/update',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => json_encode([
					'kf_account' => $account,
					'nickname' => $nickname,
					'password' => $password,
				]),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 删除客服帐号
	 * 
	 * @param string $account  账号
	 * @param string $nickname 昵称
	 * @param string $password 密码
	 * @return bool 		   是否修改成功
	 */
	public function deleteKFAccount($account, $nickname, $password)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/customservice/kfaccount/del',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => json_encode([
					'kf_account' => $account,
					'nickname' => $nickname,
					'password' => $password,
				]),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 设置客服帐号的头像
	 * 
	 * @param string $account  账号
	 * @param mixed $avatar      头像文件
	 * @return bool            是否设置成功
	 */
	public function uploadKFAccountAvatar($account, $avatar)
	{
		$json = http_post([
				'url' => 'http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg',
				'params' => [
					'access_token' => $this->getAccessToken(),
					'kf_account' => $account,
				],
				'content' => $avatar,
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}

	/**
	 * 获取所有客服账号
	 * 
	 * @return stdClass 所有客服账号
	 */
	public function getAllKFAccount()
	{
		$json = http_get([
				'url' => 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist',
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
	 * 发送客服消息
	 * 
	 * @param  mixed $message 要发送的消息
	 * @return bool           是否发送成功
	 */
	public function sendKFMessage($message)
	{
		$json = http_post([
				'url' => 'https://api.weixin.qq.com/cgi-bin/message/custom/send',
				'params' => [
					'access_token' => $this->getAccessToken(),
				],
				'content' => is_string($message) ? $message : json_encode($message),
			]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return true;
	}
}