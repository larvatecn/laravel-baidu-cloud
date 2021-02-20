<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud;

use Illuminate\Support\ServiceProvider;

/**
 * Class BceServiceProvider
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduCloudServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupConfig();

        $this->app->singleton('baidu_cloud', function () {
            return new BaiduCloudManage($this->app);
        });
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__ . '/../config/baidu.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('baidu.php'),
            ], 'baidu-config');
        }

        $this->mergeConfigFrom($source, 'baidu');
    }
}
