<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud;

use Psr\Http\Message\RequestInterface;

/**
 * Class AipStack
 * @author Tongle Xu <xutongle@gmail.com>
 */
class NlpStack
{
    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $appKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * Constructor.
     * @param string $appId
     * @param string $appKey
     * @param string $secretKey
     */
    public function __construct(string $appId, string $appKey, string $secretKey)
    {
        $this->appId = $appId;
        $this->appKey = $appKey;
        $this->secretKey = $secretKey;
    }

    /**
     * Called when the middleware is handled.
     *
     * @param callable $handler
     *
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function ($request, array $options) use ($handler) {
            $request = $this->onBefore($request);
            return $handler($request, $options);
        };
    }

    /**
     * 请求前调用
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function onBefore(RequestInterface $request)
    {
        $params = \GuzzleHttp\Psr7\Query::parse($request->getUri()->getQuery());
        $params['access_token'] = $this->getAccessToken();
        $params['charset'] = 'UTF-8';
        $body = http_build_query($params, '', '&');
        return \GuzzleHttp\Psr7\Utils::modifyRequest($request, ['query' => $body]);
    }

    /**
     * 获取授权令牌
     * @return string
     */
    private function getAccessToken(): string
    {
        $accessToken = new AccessToken($this->appId, $this->appKey, $this->secretKey);
        $token = $accessToken->getToken();
        return $token['access_token'];
    }
}
