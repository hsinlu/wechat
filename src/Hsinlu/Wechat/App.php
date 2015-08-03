<?php

namespace Hsinlu\Wechat;

use \Exception;
use \Closure;
use OutOfBoundsException;

use Hsinlu\Wechat\Foundation\AccessToken;
use Hsinlu\Wechat\Foundation\CallbackIP;
use Hsinlu\Wechat\Foundation\CustomerService;
use Hsinlu\Wechat\Foundation\MassSend;
use Hsinlu\Wechat\Foundation\Template;
use Hsinlu\Wechat\Foundation\AutoReplyRule;
use Hsinlu\Wechat\Foundation\UserManager;
use Hsinlu\Wechat\Foundation\GroupManager;
use Hsinlu\Wechat\Foundation\Menu;
use Hsinlu\Wechat\Foundation\ShortUrl;
use Hsinlu\Wechat\Foundation\QRCode;
use Hsinlu\Wechat\Foundation\Media;

use Hsinlu\Wechat\Results\Result;

class App
{
    use AccessToken, CallbackIP, CustomerService, MassSend, Template, 
        AutoReplyRule, UserManager, GroupManager, Menu, ShortUrl, QRCode, Media;

    /**
     * 应用ID
     * 
     * @var string
     */
	public $appId; 

    /**
     * 应用密钥
     * 
     * @var string
     */
	public $appSecret;
	
    /**
     * 应用令牌
     * @var string
     */
	public $token;

    /**
     * 消息是否加密
     * @var bool
     */
    public $encrypt;

    /**
     * 消息加解密密钥
     * @var string
     */
    public $encodingAESKey;

    /**
     * 执行策略
     * @var string
     */
    public $strategy;

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
    	$this->appId = $config['app_id'];
    	$this->appSecret = $config['app_secret'];
    	$this->token = $config['token'];
		$this->encrypt = $config['encrypt'];
        $this->encodingAESKey = $config['encoding_AES_key'];
        $this->strategy = $config['strategy'];
    }

    /**
     * 注册消息处理程序
     * 
     * @param  mixed $type    消息类型
     * @param  mixed $handler 消息处理程序
     */
    public function on($type, $handler)
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
        // 事件类型时设置为事件类型+具体事件，如event.subscribe
        if ($type == 'event') {
            $type .= '.' . trim($message->Event); 
        }

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