<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud;

use GuzzleHttp\Exception\GuzzleException;
use Larva\Support\Traits\HasHttpRequest;

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

    /**
     * Issue a GET request to the given URL.
     *
     * @param string $url
     * @param array|string|null $query
     * @return array
     * @throws GuzzleException
     */
    public function getJSON(string $url, $query = null)
    {
        $this->acceptJson();
        $response = $this->get($url, $query);
        return $response->json();
    }

    /**
     * Issue a POST request to the given URL.
     *
     * @param string $url
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function postJSON(string $url, array $data = [])
    {
        $this->acceptJson();
        $this->asJson();
        $response = $this->post($url, $data);
        return $response->json();
    }

    /**
     * Issue a PATCH request to the given URL.
     *
     * @param string $url
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function patchJSON(string $url, $data = [])
    {
        $this->acceptJson();
        $this->asJson();
        $response = $this->patch($url, $data);
        return $response->json();
    }

    /**
     * Issue a PUT request to the given URL.
     *
     * @param string $url
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function putJSON(string $url, $data = [])
    {
        $this->acceptJson();
        $this->asJson();
        $response = $this->put($url, $data);
        return $response->json();
    }

    /**
     * Issue a DELETE request to the given URL.
     *
     * @param string $url
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function deleteJSON(string $url, $data = [])
    {
        $this->acceptJson();
        $this->asJson();
        $response = $this->delete($url, $data);
        return $response->json();
    }

}
