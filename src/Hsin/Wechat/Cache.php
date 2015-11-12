<?php

namespace Hsin\Wechat;

use \Closure;
use \InvalidArgumentException;

class Cache
{
	/**
	 * 缓存存储的路径
	 * @var string
	 */
	public $cachePath = '../cache/';

	/**
	 * 缓存指定Key的值
	 * 
	 * @param  mixed $key   缓存Key
	 * @param  Closure $closure 缓存值获取程序
	 * @param  int $minutes 缓存时间
	 * @return mixed        缓存值
	 */
	public function remember($key, Closure $closure, $minutes = 0)
	{
		$value = $this->get($key);

		if (! is_null($value)) {
			return $value;
		}

		$filename = $this->getFileName($key);

		if (! isset($closure)) {
			throw new InvalidArgumentException('缓存值获取程序不能为空！');
		}

		$value = call_user_func($closure);

		$this->put($filename, $this->expiration($minutes).serialize($value));

		return $value;
	}

	/**
	 * 缓存写入文件
	 * 
	 * @param  string $filename 缓存文件路径
	 * @param  string $value    缓存内容
	 * @return void
	 */
	private function put($filename, $value)
	{
		$dir = dirname($filename);

		if (! is_dir($dir)) {
			mkdir(iconv("UTF-8", "GBK", $dir), 0777, true); 
		}

       	//写文件, 文件锁避免出错
        file_put_contents($filename, $value, LOCK_EX);
	}

	/**
	 * 获取缓存
	 * 
	 * @param  mixed $key   缓存Key
	 * @return mixed        缓存值
	 */
    public function get($key) {
        $filename = $this->getFileName($key);

    	if (! file_exists($filename)) {
    		return null;
    	}

    	$expire = substr($contents = file_get_contents($filename), 0, 10);

 		if (time() >= $expire) {
 			$this->forget($key);

 			return null;
 		}

 		$data = unserialize(substr($contents, 10));

        return $data;
    }

	/**
	 * 删除缓存
	 * 
	 * @param  mixed $key 缓存Key
	 */
	public function forget($key)
	{
		unlink($this->getFileName($key));
	}

	/**
	 * 计算缓存时间
	 * 
	 * @param  int $minutes 缓存时间分钟
	 * @return int          过期时间
	 */
    protected function expiration($minutes)
    {
        if ($minutes === 0) {
            return 9999999999;
        }
        return time() + ($minutes * 60);
    }

	/**
	 * 根据Key获取文件完整路径
	 * 
	 * @param  string $key 缓存存储Key
	 * @return string      缓存文件路径
	 */
	protected function getFileName($key)
	{
		return $this->cachePath.$this->getKey($key);
	}

	/**
	 * 获取存储Key
	 * 
	 * @param  mixed $key 缓存Key
	 * @return string     缓存存储Key
	 */
	protected function getKey($key)
	{
		return md5($key);
	}
}