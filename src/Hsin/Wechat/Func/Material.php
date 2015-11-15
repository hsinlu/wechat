<?php

namespace Hsin\Wechat\Func;

use Hsin\Wechat\WechatException;
use \Exception;

/**
 * 素材管理
 */
trait Material
{
	/**
	 * 上传图文消息内的图片获取URL
	 * 
	 * @param  string $file 上传的文件（图片仅支持jpg/png格式，大小必须在1MB以下）
	 * @return string       url
	 */
	public function uploadImg($file)
	{
		if (filesize($file) > 1024 * 1024) {
			throw new Exception(sprintf(trans('wechat.file_max'), '1M'));
		}

		if (!in_array(mb_strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'png'])) {
			throw new Exception(sprintf(trans('wechat.file_type'), '*.jpg, *.png'));
		}

		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/media/uploadimg', [
			'query' => [
				'access_token' => wechat()->getAccessToken(),
			],
			'multipart' => [
				[
		            'name' => basename($file),
		            'filename' => basename($file),
		            'contents' => fopen($file, 'r'),
		        ],
			]
		]);

		$this->exceptionOrNot($json);

		return $json->url;
	}

	/**
	 * 上传图文消息素材【订阅号与服务号认证后均可用】
	 * 
	 * @param  string or array $articles 图文消息
	 * @return stdClass           		 json
	 */
	public function uploadNews($articles)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/media/uploadnews', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'body' => is_string($articles) ? $articles : json_encode($articles, JSON_UNESCAPED_UNICODE),
		]);

		$this->exceptionOrNot($json);

		return $json;
	}

	/**
	 * 上传临时素材
	 * 
	 * @param  string $type 素材类型（图片（image）、语音（voice）、视频（video）和缩略图（thumb））
	 * @param  string $file 	上传的素材路径
	 * @return stdClass     json
	 */
	public function uploadTempMaterial($type, $file)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/media/upload', [
			'query' => [
				'access_token' => $this->getAccessToken(),
				'type' => $type,
			],
			'multipart' => [
				[
		            'name' => 'media',
		            'filename' => basename($file),
		            'contents' => fopen($file, 'r')
		        ],
			]
		]);

		$this->exceptionOrNot($json);

		return $json;
	}

	/**
	 * 获取临时素材
	 * @param string $media_id 临时素材id
	 * @param string $savePath 临时素材存储路径
	 * @return mixed 
	 */
	public function downloadTempMaterial($media_id, $savePath = false)
	{
		$response = $this->http->get('https://api.weixin.qq.com/cgi-bin/media/get', [
			'query' => [
				'access_token' => $this->getAccessToken(),
				'media_id' => $media_id,
			]
		])->response();

		if ($response->getHeaderLine('Content-Type') == 'text/plain') {
			$json = $this->http->parseBody($response->getBody(), 'json');

			$this->exceptionOrNot($json);

			return $json;
		}

		$content = $this->http->parseBody($response->getBody(), 'content');

		if (! $savePath) return $content;

		$fp = fopen($savePath, 'w');
		if ($fp) {
			fwrite($fp, $content);
			fclose($fp);
		}
	}

	/**
	 * 新增永久图文素材
	 * 
	 * @param string|array $articles 多段图文
	 * @return string 资源ID
	 */
	public function addForeverNews($news)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/material/add_news', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'body' => is_string($news) ? $news : json_encode($news, JSON_UNESCAPED_UNICODE),
		]);

		$this->exceptionOrNot($json);

		return $json->media_id;
	}

	/**
	 * 修改永久图文素材
	 * 
	 * @param string $media_id 图文资源ID
	 * @param string|array $articles 图文
	 * @param int $index 多图文中的位置，仅多图文有效
	 * @return boolean     是否修改成功
	 */
	public function updateForeverNews($media_id, $article, $index = 0)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/material/update_news', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'body' => json_encode([
				'media_id' => $media_id,
				'index' => $index,
				'articles' => $articles,
			], JSON_UNESCAPED_UNICODE),
		]);

		$this->exceptionOrNot($json);

		return true;
	}

	/**
	 * 上传永久素材
	 * 
	 * @return [type] [description]
	 */
	public function uploadForeverMaterial($type, $file)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/material/add_material', [
			'query' => [
				'access_token' => $this->getAccessToken(),
				'type' => $type,
			],
			'multipart' => [
				[
		            'name' => 'media',
		            'filename' => basename($file),
		            'contents' => fopen($file, 'r'),
		        ],
			]
		]);

		$this->exceptionOrNot($json);

		return $json;
	}

	/**
	 * 获取永久素材
	 * 
	 * @param  string  $media_id 素材ID
	 * @param  boolean $savePath 保存路径
	 * @return mixed            
	 */
	public function downloadForeverMaterial($media_id, $savePath = false)
	{
		$response = $this->http->get('https://api.weixin.qq.com/cgi-bin/material/get_material', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'media_id' => $media_id ]
		])->response();

		if ($response->getHeaderLine('Content-Type') == 'text/plain') {
			$json = $this->http->parseBody($response->getBody(), 'json');

			$this->exceptionOrNot($json);

			return $json;
		}

		$content = $this->http->parseBody($response->getBody(), 'content');

		if (! $savePath) return $content;

		$fp = fopen($savePath, 'w');
		if ($fp) {
			fwrite($fp, $content);
			fclose($fp);
		}
	}

	/**
	 * 删除永久素材
	 * 
	 * @param string $media_id 要获取的素材的media_id
	 * @return  boolean 是否删除成功
	 */
	public function deleteForeverMaterial($media_id)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/material/del_material', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [ 'media_id' => $media_id ]
		]);

		$this->exceptionOrNot($json);

		return true;
	}

	/**
	 * 获取素材列表
	 * 
	 * @param  string $type   素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
	 * @param  int 	  $offset 从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
	 * @param  int    $count  返回素材的数量，取值在1到20之间
	 * @return stdClass       json
	 */
	public function getMaterialList($type, $offset = 0, $count = 20)
	{
		$json = $this->http->postJson('https://api.weixin.qq.com/cgi-bin/material/batchget_material', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			],
			'json' => [
				'type' => $type,
				'offset' => $offset,
				'count' => $count,
			]
		]);

		$this->exceptionOrNot($json);

		return $json;
	}

	/**
	 * 获取素材总数
	 * 
	 * @return stdClass json
	 */
	public function getMaterialCount()
	{
		$json = $this->http->getJson('https://api.weixin.qq.com/cgi-bin/material/get_materialcount', [
			'query' => [
				'access_token' => $this->getAccessToken(),
			]
		]);

		$this->exceptionOrNot($json);

		return $json;
	}
}