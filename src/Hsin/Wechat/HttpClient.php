<?php

namespace Hsin\Wechat;

use GuzzleHttp\Client;

class HttpClient
{
	public $response;

	public function get($url, $options)
	{
		return $this->request('GET', $url, $options);
	}

	public function post($url, $options)
	{
		return $this->request('POST', $url, $options);
	}

	public function request($method, $url, $options)
	{
		$client = new Client();
        $this->response = $client->request($method, $url, $options);

		return $this;
	}

	public function response()
	{
		return $this->response;
	}

	public function raw()
	{
		return $this->parseBody($this->response->getBody(), 'raw');
	}

	public function json()
	{
		return $this->parseBody($this->response->getBody(), 'json'); 
	}

	public function xml()
	{
		return $this->parseBody($this->response->getBody(), 'xml'); 
	}

	private function parseBody($body, $returnedType)
	{
	    switch ($returnedType) {
	        case 'raw':
	            return $body;
	        case 'json':
	            return json_decode($body->getContents());
	        case 'xml':
	        	return simplexml_load_string($body->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);
	    }
	    throw new \InvalidArgumentException('Unknown response type ('. $returnedType .')');
	}
}