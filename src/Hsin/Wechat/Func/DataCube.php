<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;

/**
 * 数据统计接口
 */
trait DataCube
{
	/**
	 * 获取用户增减数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object   
	 */
	public function getUserSummary($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getusersummary', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取累计用户数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUserCumulate($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getusercumulate', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取图文群发每日数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getArticleSummary($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getarticlesummary', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取图文群发总数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getArticleTotal($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getarticletotal', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取图文统计数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUserRead($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getuserread', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取图文统计分时数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUserReadHour($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getuserreadhour', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取图文分享转发数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUserShare($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getusershare', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取图文分享转发分时数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUserShareHour($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getusersharehour', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取消息发送概况数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUpstreamMsg($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getupstreammsg', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取消息分送分时数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUpstreamMsgHour($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getupstreammsghour', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取消息发送周数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUpstreamMsgWeek($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getupstreammsgweek', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取消息发送月数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUpstreamMsgMonth($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getupstreammsgmonth', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取消息发送分布数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUpstreamMsgDist($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getupstreammsgdist', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取消息发送分布周数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUpstreamMsgDistWeek($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getupstreammsgdistweek', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取消息发送分布月数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getUpstreamMsgDistMonth($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getupstreammsgdistmonth', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取接口分析数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getInterfaceSummary($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getinterfacesummary', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}

	/**
	 * 获取接口分析分时数据
	 * 
	 * @param  string $begin_date 获取数据的起始日期，begin_date和end_date的差值需小于“最大时间跨度”（比如最大时间跨度为1时，begin_date和end_date的差值只能为0，才能小于1），否则会报错
	 * @param  string $end_date   获取数据的结束日期，end_date允许设置的最大值为昨日
	 * @return object             
	 */
	public function getInterfaceSummaryHour($begin_date, $end_date)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/datacube/getinterfacesummaryhour', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'begin_date' => $begin_date, 'end_date' => $end_date ]
		]);

		if (property_exists($json, 'errcode') && $json->errcode != 0) {
			throw new WechatException($json->errmsg, $json->errcode);
		}

		return $json;
	}
}