<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\UMeng\Push;

use GuzzleHttp\HandlerStack;
use Larva\Supports\BaseObject;
use Larva\Supports\Traits\HasHttpRequest;

/**
 * Class Client
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Client extends BaseObject
{
    use HasHttpRequest;

    /**
     * @var string
     */
    public $app_key;

    /**
     * @var string
     */
    public $app_master_secret;

    /**
     * @var string 安卓推送时是否启用
     */
    public $mi_activity;

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return 'https://msgapi.umeng.com';
    }

    /**
     * @return HandlerStack
     */
    public function getHandlerStack()
    {
        $stack = HandlerStack::create();
        $middleware = new PushStack($this->app_master_secret);
        $stack->push($middleware);
        return $stack;
    }

    /**
     * 发送
     * @param array|BaseMessage $message
     * @return array
     */
    public function send($message)
    {
        if ($message instanceof BaseMessage) {
            $message = $message->getJsonBody();
        }
        return $this->postJSON('api/send', $message);
    }

    /**
     * 任务类消息状态查询
     * @param string $taskId
     * @return array
     */
    public function status($taskId)
    {
        return $this->postJSON('api/status', ['task_id' => $taskId]);
    }

    /**
     * 任务类消息取消
     * @param string $taskId
     * @return array
     */
    public function clean($taskId)
    {
        return $this->postJSON('api/cancel', ['task_id' => $taskId]);
    }

    /**
     * 文件上传
     * @param string $content
     * @return array
     */
    public function upload($content)
    {
        return $this->postJSON('upload', ['content' => $content]);
    }

    /**
     * Make a post request.
     *
     * @param string $endpoint
     * @param array $params
     * @param array $headers
     * @return array
     */
    protected function postJSON($endpoint, $params = [], $headers = [])
    {
        $params['appkey'] = $this->app_key;
        $params['timestamp'] = time();
        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'json' => $params,
        ]);
    }
}