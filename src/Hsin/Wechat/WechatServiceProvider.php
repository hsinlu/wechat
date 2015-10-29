<?php

namespace Hsin\Wechat;

use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $strategyPath = base_path('app/Wechat/strategy.php');
        if (file_exists($strategyPath)) {
            require $strategyPath;
        }

        $this->publishes([
            __DIR__ . '/config/wechat.php' => config_path('wechat.php'),
            __DIR__ . '/resources/lang/' => base_path('/resources/lang/'),
            __DIR__ . '/Wechat/' => base_path('/app/Wechat/'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('wechat', function ($app) {
            return new WechatManager;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wechat'];
    }

}
