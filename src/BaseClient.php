<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Larva\Support\HttpClient;
use Larva\Support\Traits\HasHttpRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseClient
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaseClient implements BaiduCloudInterface
{
    use HasHttpRequest;

    /**
     * @var string AccessKey ID
     */
    protected $accessId;

    /**
     * @var string AccessKey
     */
    protected $accessKey;

    /**
     * BaseClient constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!empty($config)) {
            foreach ($config as $name => $value) {
                $this->$name = $value;
            }
        }
        $this->options = [
            'http_errors' => false,
        ];
    }

    /**
     * @return HttpStack
     */
    public function buildBeforeSendingHandler()
    {
        return new HttpStack($this->accessId, $this->accessKey);
    }
}
