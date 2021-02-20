<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud;

use Illuminate\Support\Manager;
use InvalidArgumentException;

/**
 * Class BceManage
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduCloudManage extends Manager
{
    /**
     * Get the bce service configuration.
     *
     * @param string $name
     * @return array
     */
    protected function getConfig(string $name): array
    {
        $config = $this->config["baidu.drivers.{$name}"] ?: [];
        if (!isset($config['access_id']) || empty ($config['access_id'])) {
            $config['access_id'] = $this->config["baidu.access_id"];
        }
        if (!isset($config['access_key']) || empty ($config['access_key'])) {
            $config['access_key'] = $this->config["baidu.access_key"];
        }
        return $config;
    }

    /**
     * Get a driver instance.
     *
     * @param string $driver
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No Tencent Cloud driver was specified.');
    }

    /**
     * 创建CDN服务
     * @return Services\Cdn
     */
    public function createCdnService()
    {
        $config = $this->getConfig('cdn');
        return new Services\Cdn(['accessId' => $config['access_id'], 'accessKey' => $config['access_key']]);
    }

    /**
     * 创建 NLP 服务
     * @return Services\Nlp
     */
    public function createNlpService()
    {
        $config = $this->getConfig('nlp');
        return new Services\Nlp(['accessId' => $config['app_id'], 'accessKey' => $config['app_key'], 'secretKey' => $config['secret_key']]);
    }
}
