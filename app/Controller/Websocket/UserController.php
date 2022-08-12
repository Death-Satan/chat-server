<?php


namespace App\Controller\Websocket;


use App\Enums\MessageType;
use App\Model\Friend;
use App\Model\Group;
use App\Model\GroupRelation;
use App\Model\User;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

class UserController extends BaseController
{

    public function handle(Server $server, Frame $frame, $data)
    {
        $type =  $data['type'] ?? null;
        $content = $data['content'] ?? null;
        switch ($type)
        {
            // 发送群聊消息消息
            case 'group_send':
                $this->group($server,$content);
                 break;
            // 发送单聊消息
            case 'friend_send':
                $this->friend($server,$content);
                 break;
            default:
                 $this->__default($server,$frame,$content);
                 break;
        }
    }

    public function group(Server $server,$data)
    {
        $msgType = $data['type'] ?? null;
        if (!MessageType::exists($msgType))
        {
            $this->send(
                $this->system([
                    'type'=>'message',
                    'content'=>'消息解析失败'
                ])
            );
        }
        $group_code_name = $data['group_code_name'];
        $group = Group::where('group_code_name',$group_code_name)->first();
        if (empty($group))
        {
            $this->send(
                $this->system([
                    'type'=>'message',
                    'content'=>'群不存在'
                ])
            );
            return;
        }
        $is_in_group = GroupRelation::where('group_id',$group->id)->where('user_id',$this->user()->id)->first();

        if (empty($is_in_group))
        {
            $this->send(
                $this->system([
                    'type'=>'message',
                    'content'=>'不在该群内'
                ])
            );
            return;
        }
        // 发布
        $this->redis->publish('message',json_encode([
            'type'=>'group',
            'content'=>[
                'type'=>$msgType,
                'from'=>$this->user()->toArray(),
                'to'=>$group->toArray(),
                'content'=>$data['content']??null
            ]
        ],JSON_UNESCAPED_UNICODE));
    }

    public function friend(Server $server,$data)
    {
        $msgType = $data['type'] ?? null;
        if (!MessageType::exists($msgType))
        {
            $this->send(
                $this->system([
                    'type'=>'message',
                    'content'=>'消息解析失败'
                ])
            );
            return;
        }
        $account = $data['to_account'] ?? null;
        $user  = User::where('account',$account)->first();
        if (empty($user))
        {
            $this->send(
                $this->system([
                    'type'=>'message',
                    'content'=>'不存在'
                ])
            );
            return;
        }

        if ($this->user()->id == $user->id)
        {
            $this->send(
                $this->system([
                    'type'=>'message',
                    'content'=>'不能与自己发送消息'
                ])
            );
            return;
        }

        //判断是否有好友
        if (!Friend::is_friend($this->user()->id,$user->id))
        {
            $this->send(
                $this->system([
                    'type'=>'message',
                    'content'=>'与对方好友状态异常'
                ])
            );
            return;
        }

        // 发布
        $this->redis->publish('message',json_encode([
            'type'=>'friend',
            'content'=>[
                'type'=>$msgType,
                'from'=>$this->user()->toArray(),
                'to'=>$user->toArray(),
                'content'=>$data['content']??null
            ]
        ],JSON_UNESCAPED_UNICODE));
    }

    // 匹配不到默认走这条
    public function __default(Server $server,Frame $frame,$data)
    {
        $server->push($frame->fd,
            $this->system([
                'type'=>'message',
                'content'=>'没有找到相关命令'
            ])
        );
    }
}