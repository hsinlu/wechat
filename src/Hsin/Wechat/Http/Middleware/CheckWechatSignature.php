<?php

namespace Hsin\Wechat\Http\Middleware;

use \Closure;

class CheckWechatSignature
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('signature') || !$request->has('timestamp') || !$request->has('nonce')) {
            throw new \Exception(trans('wechat.illegal_access'));
        }

        if (!$this->checkSignature($request)) {
            throw new \Exception(trans('wechat.illegal_access'));
        }

        return $next($request);
    }

    /**
     * 校验微信签名
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function checkSignature($request)
    {
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');

        $token = wechat_config($request->route('one'))['token'];
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        return $tmpStr == $signature;
    }
}