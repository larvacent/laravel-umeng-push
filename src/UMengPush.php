<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\UMeng\Push;

use Illuminate\Support\Facades\Facade;

/**
 * Class UMengPush
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class UMengPush extends Facade
{
    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'umengPush.android';
    }

    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function android()
    {
        return app('umengPush.android');
    }

    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function ios()
    {
        return app('umengPush.ios');
    }
}