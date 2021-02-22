<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud\Services;

use GuzzleHttp\HandlerStack;
use Larva\Baidu\Cloud\BaseClient;
use Larva\Baidu\Cloud\HttpStack;

/**
 * CDN
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Cdn extends BaseClient
{
    /**
     * The base URL for the request.
     *
     * @var string
     */
    protected $baseUrl = 'https://cdn.baidubce.com';

    /**
     * @return HttpStack
     */
    public function buildBeforeSendingHandler()
    {
        return new HttpStack($this->accessId, $this->accessKey);
    }

    /**
     * 查询用户名下所有域名
     * @param string|null $rule
     * @param string $status
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function userDomains($rule = null, $status = 'ALL')
    {
        $query = ['status' => $status];
        if ($rule) $query['rule'] = $rule;
        return $this->getJSON('/v2/user/domains', $query);
    }

    /**
     * 查询用户的域名列表
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function domains()
    {
        return $this->getJSON('/v2/domain');
    }

    /**
     * 查询域名是否可以被添加
     * @param string $domain
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function domainValid($domain)
    {
        return $this->getJSON("/v2/domain/{$domain}/valid");
    }

    /**
     * 创建一个加速域名
     * @param string $domain
     * @param array $origin
     * @param null $defaultHost
     * @param string $form 业务类型
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function domainCreate($domain, $origin, $defaultHost = null, $form = 'default')
    {
        $params = ['origin' => $origin, 'form' => $form];
        if ($defaultHost) $query['defaultHost'] = $defaultHost;
        return $this->putJSON("/v2/domain/{$domain}", $params);
    }

    /**
     * 创建一个加速域名
     * @param string $domain
     * @param $peer
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function domainCreateByPeer($domain, $peer)
    {
        $params = [
            [
                'peer' => $peer
            ]
        ];
        return $this->domainCreate($domain, $params);
    }

    /**
     * 启用域名加速
     * @param string $domain
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function domainEnable($domain)
    {
        return $this->postJSON("/v2/domain/{$domain}?enable=1");
    }

    /**
     * 禁用域名加速
     * @param string $domain
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function domainDisable($domain)
    {
        return $this->postJSON("/v2/domain/{$domain}?disable=1");
    }

    /**
     * 删除域名加速
     * @param string $domain
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function domainDelete($domain)
    {
        return $this->delete("/v2/domain/{$domain}");
    }

    /**
     * 查询域名是否备案
     * @param string $domain
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function domainICP($domain)
    {
        return $this->getJSON("/v2/domain/{$domain}/icp");
    }

    /**
     * 获取指定加速域名配置的基本信息
     * @param string $domain
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDomainConfig($domain)
    {
        return $this->getJSON("/v2/domain/{$domain}/config");
    }

    /**
     * 修改域名设置
     * @param string $domain
     * @param array $config
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setDomainConfig($domain, $config)
    {
        return $this->putJSON("/v2/domain/{$domain}/config", $config);
    }

    /**
     * 修改回源
     * @param string $domain
     * @param array $origin
     * @param string|null $host 回源HOST
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setDomainOrigin($domain, $origin, $host = null)
    {
        $params = ['origin' => $origin, 'defaultHost' => $domain];
        if ($host) $query['defaultHost'] = $host;
        return $this->putJSON("/v2/domain/{$domain}/config?origin=1", $params);
    }

    /**
     * 修改加速域名文件类型的缓存策略
     * @param string $domain
     * @param array $cacheTTL
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setCacheTTL($domain, $cacheTTL)
    {
        return $this->putJSON("/v2/domain/{$domain}/config?cacheTTL=1", [
            'cacheTTL' => $cacheTTL
        ]);
    }

    /**
     * 提交purge任务
     * @param array $tasks
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cachePurge(array $tasks)
    {
        $response = $this->post("/v2/cache/purge", [
            'tasks' => $tasks
        ]);
        return $response->json();
    }

    /**
     * 提交prefetch任务
     * @param array $tasks
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cachePrefetch($tasks)
    {
        $response = $this->post("/v2/cache/prefetch", [
            'tasks' => $tasks
        ]);
        return $response->json();
    }

}
