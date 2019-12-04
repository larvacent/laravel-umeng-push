<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\UMeng\Push;

use Larva\Supports\Exception\Exception;

/**
 * 安卓消息
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AndroidMessage extends BaseMessage
{
    /**
     * 推送结果
     * @return array
     */
    public function send()
    {
        /** @var Client $push * */
        $push = UMengPush::android();
        if (!empty($push->mi_activity)) {
            $this->setMiActivity($push->mi_activity);
        }
        return $push->send($this->jsonBody);
    }

    /**
     * 走厂商通道拉起App
     * @param string $activity
     */
    public function setMiActivity($activity)
    {
        $this->jsonBody['mipush'] = 'true';
        $this->jsonBody['mi_activity'] = $activity;
    }

    /**
     * 设置消息载荷
     * @param string $key
     * @param string|array $value
     * @return AndroidMessage
     */
    public function setPayload($key, $value)
    {
        $this->jsonBody['payload'][$key] = $value;
        if ($key == 'display_type' && $value == 'message') {
            $this->jsonBody['payload']['body']['ticker'] = "";
            $this->jsonBody['payload']['body']['title'] = "";
            $this->jsonBody['payload']['body']['text'] = "";
            $this->jsonBody['payload']['body']['after_open'] = "";
            if (!array_key_exists('custom', $this->jsonBody['payload']['body'])) {
                $this->jsonBody['payload']['body']['custom'] = null;
            }
        }
        return $this;
    }

    /**
     * 设置扩展字段
     * @param string $key
     * @param string $value
     * @return AndroidMessage
     * @throws Exception
     */
    public function setExtraField($key, $value)
    {
        if (!is_string($key)) {
            throw new Exception("key should be a string!");
        }
        $this->jsonBody['payload']['extra'][$key] = $value;
        return $this;
    }

    /**
     * 设置载荷
     * @param string $key
     * @param string|array $value
     * @return AndroidMessage
     */
    public function setPayloadBody($key, $value)
    {
        $this->jsonBody['payload']['body'][$key] = $value;
        if ($key == 'after_open' && $value == 'go_custom' && !array_key_exists('custom', $this->jsonBody['payload']['body'])) {
            $this->jsonBody['payload']['body']['custom'] = null;
        }
        return $this;
    }
}