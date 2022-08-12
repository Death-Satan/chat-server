<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @author   Death-Satan
 * @email    death-satan@qq.com
 */
namespace App\Controller\Websocket;

use App\Model\User;
use App\Model\UserToken;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Hyperf\WebSocketServer\Context;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use Hyperf\WebSocketServer\Sender;

abstract class BaseController implements OnMessageInterface, OnOpenInterface
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected Redis $redis;

    #[Inject]
    protected Sender $sender;

    public function onMessage($server, Frame $frame): void
    {
        $data = json_decode($frame->data, true);
        $this->handle($server, $frame, $data);
    }

    abstract public function handle(Server $server, Frame $frame, $data);

    public function onOpen($server, Request $request): void
    {
        $app_name = env('APP_NAME');
        if ($server instanceof Server && $request instanceof Request) {
            $token = $request->get['token'] ?? null;
            $tokenEnt = UserToken::where('token', $token)->first();
            if (empty($tokenEnt)) {
                $server->push($request->fd, 'token失效');
                $server->close($request->fd);
            }
            $user = User::where('id', $tokenEnt->user_id)->first();
            if (empty($tokenEnt)) {
                $server->push($request->fd, '用户不存在');
                $server->close($request->fd);
            }
            $this->redis->set($app_name.'_user_id_' . $user->id, $request->fd);
            Context::set('user', $user);
        }
    }

    protected function getFd()
    {
        $app_name = env('APP_NAME');
        $user_id = $this->user()->id;
        return $this->redis->get($app_name.'_user_id_'.$user_id);
    }

    protected function send($data)
    {
        $this->sender->push($this->getFd(),$data);
    }

    public function onClose($server, int $fd, int $reactorId): void
    {
        $app_name = env('APP_NAME');
        $user = $this->user();
        // 离线就删除redis关联
        $this->redis->del($app_name.'_user_id_' . $user->id);
    }

    protected function user(): User
    {
        return Context::get('user');
    }

    protected function system($data): bool|string
    {
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}
