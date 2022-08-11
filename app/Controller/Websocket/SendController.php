<?php

declare(strict_types=1);

namespace App\Controller\Websocket;

use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class SendController extends BaseController
{
    public function handle(Server $server, Frame $frame, $data)
    {

    }
}
