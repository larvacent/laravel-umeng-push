<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\UMeng\Push;


use Larva\Supports\Exception\Exception;

/**
 * Class AndroidMessage
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class AndroidMessage extends Message
{
    /**
     * 推送结果
     * @return array
     */
    public function send()
    {
        /** @var Client $push * */
        $push = UMengPush::android();
        return $push->send($this->jsonBody);
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