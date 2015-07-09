<?php

namespace Hsinlu\Wechat;

use \Exception;
use \Closure;
use OutOfBoundsException;
use Hsinlu\Wechat\Results\Result;

class App
{
    /**
     * 应用ID
     * 
     * @var string
     */
	protected $app_id; 

    /**
     * 应用密钥
     * 
     * @var string
     */
	protected $app_secret;
	
    /**
     * 应用令牌
     * @var string
     */
	protected $token;

    /**
     * 应用接入url
     * 
     * @var string
     */
	protected $url;

    /**
     * 消息处理程序
     * 
     * @var array
     */
    protected $handlers = [];

    /**
     * 创建应用实例
     * @param array $config 应用配置
     */
    function __construct($config)
    {
    	$this->app_id = $config['AppID'];
    	$this->app_secret = $config['AppSecret'];
    	$this->token = $config['Token'];
		$this->url = $config['URL'];
    }

    /**
     * 注册消息处理程序
     * 
     * @param  mixed $type    消息类型
     * @param  mixed $handler 消息处理程序
     */
    public function registerHandler($type, $handler)
    {
    	if (is_array($type)) {
    		foreach ($type as $key => $value) {
    			$this->addOrModifyHandler($key, $value);
    		}
    	} else {
    		if (!isset($handler)) {
    			throw new Exception(trans('wechat.handler_null'));
    		}

    		$this->addOrModifyHandler($type, $handler);
    	}
    }

    /**
     * 新增或更改消息处理程序
     * 
     * @param string $type    消息类型
     * @param mixed $handler 处理程序
     */
    protected function addOrModifyHandler($type, $handler)
    {
    	if (isset($this->handlers[$type])) {
    		$this->handlers[$type] = $handler;
    	} else {
    		$this->handlers[$type] = $handler;
    	}
    }

    /**
     * 触发消息处理程序
     * 
     * @param  SimpleXMLElement $message 微信主动推送的消息
     * @return string             返回给微信的消息
     */
    public function handle($message)
    {
        $type = trim($message->MsgType);

        if (!isset($this->handlers[$type])) {
            throw new OutOfBoundsException(trans('wechat.hanlder_not_available'));
        }

        $handler = $this->handlers[$type];

        // 消息处理程序为闭包
        if ($handler instanceof Closure) {
            $result = $handler($message);
        } else {
            $handler = new $handler;

            $result = $handler->handle($message);
        }

        // 返回结果为Result类型，执行Result的execute方法
        if ($result instanceof Result) {
            return $result->exec();
        }

        return $result;
    }
}