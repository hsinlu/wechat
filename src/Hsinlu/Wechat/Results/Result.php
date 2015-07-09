<?php

namespace Hsinlu\Wechat\Results;

abstract class Result
{
	protected $data = [];

	public function __construct($data)
    {
        $this->data = $data;
    }

    abstract public function exec();
}