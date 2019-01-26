<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
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
        /** @var Message|false $message */
        if(($message = $notification->toDevice($notifiable)) != false){
            $message->send();
        }
    }
}