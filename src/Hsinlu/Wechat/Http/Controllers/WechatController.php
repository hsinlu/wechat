<?php

namespace Hsinlu\Wechat\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * 微信控制器，负责微信的接入验证和微信主动推送消息的处理
 * 
 */
class WechatController extends Controller
{
    function __construct()
    {
        // $this->middleware('checkWechatSignature');
    }

    /**
     * GET请求，视为接入验证
     * 
     * @param  Request $request 请求
     * @param  [type]  $uniqid  应用的唯一标识，为空时默认为配置中得第一个
     * @return [type]           响应内容
     */
    public function getAccess(Request $request, $uniqid = null) 
    {
        // 校验通过后直接返回请求中的echostr
        return $request->input('echostr');
    }

    /**
     * POST请求，由微信主动推送的消息
     * 
     * @param  Request $request 请求
     * @param  [type]  $uniqid  应用的唯一标识，为空时默认为配置中得第一个
     * @return [type]           返回给微信的消息
     */
    public function postAccess(Request $request, $uniqid = null)
    {
        $message = $request->getContent();

        if (empty($message)) {
            echo trans('wechat.data_error');
            exit;
        }
        
        $app = wechat($uniqid);

        // 找不到uniqid的应用，终止执行
        if (is_null($app)) {
            echo trans('wechat.wechat_not_available');
            exit;
        }

        // 应用的执行策略不为空时，加载应用的执行策略
        if (!empty($app->strategy)) {
            require base_path('app/wechat-strategies/' . $app->strategy);
        }

        $message = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);
        return response($app->handle($message))->header('Content-Type', 'application/xml');
    }
}