<?php

use Vinelab\Http\Client as HttpClient;
use InvalidArgumentException;

if (!function_exists('http_get')) {
	/**
	 * Get请求http资源
	 * 
	 * @param  string or array $request 请求
	 * @return string     json|xml|raw
	 */
	function http_get($request, $resType = 'json')
	{
		$client = new HttpClient;
		$response = $client->get($request);

		switch ($resType) {
			case 'raw':
				return $response->content();
			case 'json':
				return $response->json();
			case 'xml':
				return $response->xml();
		}

		throw new InvalidArgumentException('Unknown response type ('. $resType .')');
	}
}

if (!function_exists('http_post')) {
	/**
	 * Post请求http资源
	 * 
	 * @param  string or array $request 请求
	 * @return string     json|xml|raw
	 */
	function http_post($request, $resType = 'json')
	{
		// post请求时将params附加到url中，并删除params
		if (is_array($request) && isset($request['params'])) {
			$request['url'] .= '?' . http_build_query($request['params']);
			array_forget($request, 'params');
		}

		$client = new HttpClient;
		$response = $client->post($request);

		switch ($resType) {
			case 'raw':
				return $response->content();
			case 'json':
				return $response->json();
			case 'xml':
				return $response->xml();
		}

		throw new InvalidArgumentException('Unknown response type ('. $resType .')');
	}
}