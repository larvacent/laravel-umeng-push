<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\UMeng\Push;

use Psr\Http\Message\RequestInterface;

/**
 * Class PushStack
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PushStack
{
    /** @var string */
    private $appMasterSecret;

    /**
     * PushStack constructor.
     * @param string $appMasterSecret
     */
    public function __construct($appMasterSecret)
    {
        $this->appMasterSecret = $appMasterSecret;
    }

    /**
     * Called when the middleware is handled.
     *
     * @param callable $handler
     *
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function ($request, array $options) use ($handler) {
            $request = $this->onBefore($request);
            return $handler($request, $options);
        };
    }

    /**
     * 请求前调用
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function onBefore(RequestInterface $request)
    {
        $postBody = $request->getBody()->getContents();
        $sign = md5($request->getMethod() . $request->getUri() . $postBody . $this->appMasterSecret);
        $query = http_build_query(['sign' => $sign], '', '&');
        $request = \GuzzleHttp\Psr7\modify_request($request, ['body' => $postBody, 'query' => $query]);
        return $request;
    }
}