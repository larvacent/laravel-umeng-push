<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\UMeng\Push;

use Illuminate\Notifications\Notification;

/**
 * Class DeviceChannel
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DeviceChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var BaseMessage|false $message */
        if(($message = $notification->toDevice($notifiable)) != false){
            $message->send();
        }
    }
}