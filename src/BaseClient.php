<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud;

use Larva\Support\HttpClient;

/**
 * Class BaseClient
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaseClient extends HttpClient implements BaiduCloudInterface
{
    /**
     * @var string AccessKey ID
     */
    protected $accessId;

    /**
     * @var string AccessKey
     */
    protected $accessKey;

    /**
     * @return HttpStack
     */
    public function buildBeforeSendingHandler()
    {
        return new HttpStack($this->accessId, $this->accessKey);
    }
}
