<?php

declare(strict_types=1);

namespace App\Controller\Websocket;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class MessageController extends BaseController
{
    public function handle(Server $server, Frame $frame, $data)
    {
        
    }
}
