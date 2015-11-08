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

	public function getJson($url, $options)
	{
		return $this->get($url, $options)->json();
	}

	public function getXml($url, $options)
	{
		return $this->get($url, $options)->xml();
	}

	public function post($url, $options)
	{
		return $this->request('POST', $url, $options);
	}

	public function postJson($url, $options)
	{
		return $this->post($url, $options)->json();
	}

	public function postXml($url, $options)
	{
		return $this->post($url, $options)->xml();
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

	public function content()
	{
		return $this->parseBody($this->response->getBody(), 'content');	
	}

	public function json()
	{
		return $this->parseBody($this->response->getBody(), 'json'); 
	}

	public function xml()
	{
		return $this->parseBody($this->response->getBody(), 'xml'); 
	}

	public function parseBody($body, $returnedType)
	{
	    switch ($returnedType) {
	        case 'raw':
	            return $body;
	        case 'content':
	        	return $body->getContents();
	        case 'json':
	            return json_decode($body->getContents());
	        case 'xml':
	        	return simplexml_load_string($body->getContents(), 'SimpleXMLElement', LIBXML_NOCDATA);
	    }
	    throw new \InvalidArgumentException('Unknown response type ('. $returnedType .')');
	}
}