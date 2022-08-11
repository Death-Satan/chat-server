<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @author   Death-Satan
 * @email    death-satan@qq.com
 */
namespace App\Controller\Websocket;

use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;

class BaseController implements OnMessageInterface, OnOpenInterface
{
    public function onMessage($server, Frame $frame): void
    {
        // TODO: Implement onMessage() method.
    }

    public function onOpen($server, Request $request): void
    {
        // TODO: Implement onOpen() method.
    }

    public function onClose($server, int $fd, int $reactorId): void
    {
        var_dump('closed');
    }
}
