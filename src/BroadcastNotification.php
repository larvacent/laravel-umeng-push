<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\UMeng\Push;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * 广播通知
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BroadcastNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    public $ticker;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $body;

    /**
     * @var string 广播推送
     */
    public $notificationType = 'broadcast';

    /**
     * @var string 消息类型
     */
    public $displayType = 'notification';

    /**
     * Create a new notification instance.
     *
     * @param string $ticker
     * @param string $title
     * @param string $body
     */
    public function __construct($ticker, $title, $body)
    {
        $this->ticker = $ticker;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DeviceChannel::class];
    }

    /**
     * @param mixed $notifiable
     * @return BaseMessage|false
     */
    public function toDevice($notifiable)
    {
        /** @var Device $device */
        if (!$device = $notifiable->routeNotificationFor('device', $this)) {
            return false;
        }
        if ($device->isAndroid()) {
            $message = new AndroidMessage();
            $message->setDeviceTokens($device->token);
            $message->setType($this->notificationType);//广播推送
            $message->setPayload('display_type', $this->displayType);//通知消息
            $message->setPayloadBody('ticker', $this->ticker);// 必填，通知栏提示文字
            $message->setPayloadBody('title', $this->title);// 必填，通知标题
            $message->setPayloadBody('text', $this->body);// 必填，通知文字描述
        } else {
            $message = new IOSMessage();
            $message->setDeviceTokens($device->token);
            $message->setType($this->notificationType);//广播推送
            $message->setPayload('display_type', $this->displayType);//通知消息
            $message->setAPS('alert', [
                'title' => $this->ticker,
                'subtitle' => $this->title,
                'body' => $this->body,
            ]);
        }
        return $message;
    }

}