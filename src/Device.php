<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\UMeng\Push;

/**
 * Class Device
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Device
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    public $os;

    /**
     * Device constructor.
     * @param string $token
     * @param string $os
     */
    public function __construct($token, $os)
    {
        $this->token = $token;
        $this->os = $os;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getOS()
    {
        return $this->os;
    }

    /**
     * 是否是安卓
     * @return bool
     */
    public function isAndroid()
    {
        return strtolower($this->os) == 'android';
    }

    /**
     * 是否是IOS
     * @return bool
     */
    public function isIOS()
    {
        return strtolower($this->os) == 'ios';
    }
}