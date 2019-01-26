<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\UMeng\Push;

/**
 * Class IOSMessage
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class IOSMessage extends Message
{
    /**
     * 推送结果
     * @return array
     */
    public function send()
    {
        /** @var Client $push * */
        $push = UMengPush::ios();
        return $push->send($this->jsonBody);
    }

    /**
     * 设置APS参数
     * @param string $key
     * @param string|array $value
     * @return IOSMessage
     */
    public function setAPS($key, $value)
    {
        $this->jsonBody['payload']['aps'][$key] = $value;
        return $this;
    }
}