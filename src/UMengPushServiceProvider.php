<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\UMeng\Push;

use Illuminate\Support\ServiceProvider;

/**
 * Class UMengPushServiceProvider
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UMengPushServiceProvider extends ServiceProvider
{
    /**
     * If is defer.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service.
     *
     * @author yansongda <me@yansongda.cn>
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                dirname(__DIR__).'/config/umeng-push.php' => config_path('umeng-push.php'), ],
                'umeng-push'
            );
        }
    }

    /**
     * Register the service.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/config/umeng-push.php', 'umeng-push');

        $this->app->singleton('umengPush.android', function () {
            return new Client(config('umeng-push.android'));
        });
        $this->app->singleton('umengPush.ios', function () {
            return new Client(config('umeng-push.ios'));
        });
    }

    /**
     * Get services.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return array
     */
    public function provides()
    {
        return ['umengPush.android', 'umengPush.ios'];
    }
}