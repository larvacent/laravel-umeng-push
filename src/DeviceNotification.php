<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\UMeng\Push;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * 设备通知基类
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DeviceNotification extends Notification implements ShouldQueue
{
    use Queueable;

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
     * @return Message|false
     */
    public function toDevice($notifiable)
    {
        /** @var Device $device */
        if (!$device = $notifiable->routeNotificationFor('device', $this)) {
            return false;
        }

        $message = [
            'ticker' => '我们刚刚给用户增加了个通知功能。',    // 必填，通知栏提示文字
            'title' => '我们刚刚给用户增加了个通知功能。',    // 必填，通知标题
            'text' => '所以得测试测试好使不好使！',    // 必填，通知文字描述
        ];
        if ($device->isAndroid()) {
            $android = new AndroidMessage();
            $android->setDeviceTokens($device->token);
            $android->setType('unicast');//点对点推送
            $android->setPayload('display_type', 'notification');//通知消息
            $android->setPayloadBody('ticker', $message['ticker']);// 必填，通知栏提示文字
            $android->setPayloadBody('title', $message['title']);// 必填，通知标题
            $android->setPayloadBody('text', $message['text']);// 必填，通知文字描述

            return $android;
        } else {
            $ios = new IOSMessage();
            $ios->setDeviceTokens($device->token);
            $ios->setType('unicast');//点对点推送
            $ios->setPayload('display_type', 'notification');//通知消息
            $ios->setAPS('alert', [
                'title' => $message['ticker'],
                'subtitle' => $message['title'],
                'body' => $message['text'],
            ]);
            return $ios;
        }
    }
}