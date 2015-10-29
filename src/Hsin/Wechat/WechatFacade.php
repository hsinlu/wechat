<?php

namespace Hsin\Wechat;

use Illuminate\Support\Facades\Facade;

class WechatFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wechat';
    }
}