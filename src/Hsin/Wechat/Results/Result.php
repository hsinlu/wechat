<?php

namespace Hsin\Wechat\Results;

/**
 * 结果消息
 */
abstract class Result
{
	/**
	 * 结果所需要的数据数组
	 * @var array
	 */
	protected $data = [];

	/**
	 * 创建结果实例
	 * @param array $data 结果所需要的数据数组
	 */
	public function __construct($data)
    {
        $this->data = $data;
    }

    /**
	 * 执行并返回微信预定义的XML格式
	 * 
	 * @return string xml
	 */
    abstract public function exec();
}