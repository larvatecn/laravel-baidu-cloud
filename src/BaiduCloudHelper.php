<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Cloud;

/**
 * 快速操作助手
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduCloudHelper
{
    /**
     * 内容审核
     * @param string $content
     * @return array
     */
    public static function textModeration($content)
    {
        $response = \Larva\Baidu\Cloud\BaiduCloud::nlp()->textCensor($content);
        $keyWords = [];
        if ($response['conclusionType'] != 1 && isset($response['data'])) {//不合规
            foreach ($response['data'] as $res) {
                $hits = array_shift($res['hits']);
                $keyWords = array_merge($keyWords, $hits['words']);
            }
        }
        return $keyWords;
    }

    /**
     * 图片审核
     * @param string $path
     * @param false $isRemote
     * @return bool
     */
    public static function imageModeration($path, $isRemote = false)
    {
        if ($isRemote) {
            $path = base64_encode(file_get_contents($path));
        }
        $response = \Larva\Baidu\Cloud\BaiduCloud::nlp()->imageCensor($path);
        if ($response['conclusionType'] != 1 && isset($response['data'])) {//不合规
            return false;
        }
        return true;
    }

    /**
     * 抽取关键词
     * @param string $title
     * @param null|string $content
     * @return array
     */
    public static function keywordsExtraction($title, $content = null)
    {
        return \Larva\Baidu\Cloud\BaiduCloud::nlp()->keywords($title, $content);
    }

    /**
     * 词法分析
     * @param string $text
     * @return array
     */
    public static function keywordsExtraction2($text)
    {
        $words = \Larva\Baidu\Cloud\BaiduCloud::nlp()->lexicalAnalysis($text);
        $keywords = [];
        if (isset($words['items']) && is_array($words['items'])) {
            foreach ($words['items'] as $item) {
                if ((!empty($item['pos']) && in_array($item['pos'], ['a', 'm', 'c', 'f', 'v', 'ad', 'q', 'u', 'vd', 'an', 'f', 'xc', 't', 'vn', 'd', 'p', 'w'])) || mb_strlen($item['item']) < 2) {
                    continue;
                }
                $keywords[] = $item['item'];
            }
        }
        return $keywords;
    }
}
