<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud;

use Illuminate\Support\Facades\Facade;
use Larva\Baidu\Cloud\Services\Cdn;
use Larva\Baidu\Cloud\Services\Nlp;
use Larva\Baidu\Cloud\Services\Sms;

/**
 * 云助手
 * @mixin BaiduCloudManage
 * @method static BaiduCloudInterface with($driver)
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduCloud extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'baidu.cloud';
    }

    /**
     * 获取 CDN
     * @return Cdn
     */
    public static function cdn()
    {
        return static::getFacadeRoot()->with('cdn');
    }

    /**
     * 获取 NLP
     * @return Nlp
     */
    public static function nlp()
    {
        return static::getFacadeRoot()->with('nlp');
    }

    /**
     * 获取 SMS
     * @return Sms
     */
    public static function sms()
    {
        return static::getFacadeRoot()->with('sms');
    }
}
