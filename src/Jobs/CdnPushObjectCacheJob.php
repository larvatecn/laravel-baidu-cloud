<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Larva\Baidu\Cloud\BaiduCloud;
use Larva\Baidu\Cloud\Services\Cdn;

/**
 * Class CdnPushObjectCacheJob
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CdnPushObjectCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 3;

    /**
     * @var array
     */
    public $urls;

    /**
     * @var string 内容类型
     */
    public $objectType;

    /**
     * Create a new job instance.
     *
     * @param string|array $urls
     * @param $objectType
     */
    public function __construct($urls, $objectType = 'file')
    {
        if (is_string($urls)) {
            $this->urls = [$urls];
        } else {
            $this->urls = $urls;
        }
        $this->objectType = $objectType;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $tasks = [];
            foreach ($this->urls as $task) {
                $tasks[] = [
                    'url' => $task,
                ];
            }
            BaiduCloud::cdn()->cachePrefetch($tasks);
        } catch (\Exception $exception) {

        }
    }
}
