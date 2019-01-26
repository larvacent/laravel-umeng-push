<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\UMeng\Push;

/**
 * Class Message
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
abstract class Message
{
    public $jsonBody = [
        'production_mode' => 'true',
        'type' => 'broadcast'//默认广播
    ];

    /**
     * @return array
     */
    public function getJsonBody()
    {
        return $this->jsonBody;
    }

    /**
     * 推送结果
     * @return array
     */
    abstract public function send();


    /**
     * 设置发送模式
     * @param bool $productionMode
     * @return $this
     */
    public function setProductionMode($productionMode)
    {
        $this->jsonBody['production_mode'] = $productionMode ? 'true' : 'false';
        return $this;
    }

    /**
     * 设置设备
     * @param string|array $tokens 当type=unicast时, 必填, 表示指定的单个设备
     * 当type=listcast时, 必填, 要求不超过500个, 以英文逗号分隔
     * @return Message
     */
    public function setDeviceTokens($tokens)
    {
        if (is_array($tokens)) {
            $tokens = implode(',', $tokens);
        }
        $this->jsonBody['device_tokens'] = $tokens;
        return $this;
    }

    /**
     * 设置推送类型
     * @param string $type //   unicast-单播
     * //   listcast-列播，要求不超过500个device_token
     * //   filecast-文件播，多个device_token可通过文件形式批量发送
     * //   broadcast-广播
     * //   groupcast-组播，按照filter筛选用户群, 请参照filter参数
     * //   customizedcast，通过alias进行推送，包括以下两种case:
     * //     - alias: 对单个或者多个alias进行推送
     * //     - file_id: 将alias存放到文件后，根据file_id来推送
     * @return $this;
     */
    public function setType($type)
    {
        $this->jsonBody['type'] = $type;
        return $this;
    }

    /**
     * 别名类型
     * @param string $type
     * @return Message
     */
    public function setAliasType($type)
    {
        $this->jsonBody['alias_type'] = $type;
        return $this;
    }

    /**
     * 别名
     * @param string $alias
     * @return Message
     */
    public function setAlias($alias)
    {
        $this->jsonBody['alias'] = $alias;
        return $this;
    }

    /**
     * @param string $fileId
     * @return Message
     */
    public function setFileId($fileId)
    {
        $this->jsonBody['file_id'] = $fileId;
        return $this;
    }

    /**
     * 设置过滤策略
     * @param string $key
     * @param string|array $value
     * @return Message
     */
    public function setFilter($key, $value)
    {
        $this->jsonBody['filter'][$key] = $value;
        return $this;
    }

    /**
     * 设置消息载荷
     * @param string $key
     * @param string|array $value
     * @return Message
     */
    public function setPayload($key, $value)
    {
        $this->jsonBody['payload'][$key] = $value;
        return $this;
    }

    /**
     * 设置发送策略
     * @param string $key
     * @param string|array $value
     * @return Message
     */
    public function setPolicy($key, $value)
    {
        $this->jsonBody['policy'][$key] = $value;
        return $this;
    }

    /**
     * 发送消息描述，建议填写。
     * @param string $description 可选，发送消息描述，建议填写。
     * @return Message
     */
    public function setDescription($description)
    {
        $this->jsonBody['description'] = $description;
        return $this;
    }
}