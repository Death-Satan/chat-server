<?php

declare(strict_types=1);

namespace App\Process;

use App\Model\GroupRelation;
use Hyperf\Process\AbstractProcess;
use Hyperf\Process\Annotation\Process;
use Hyperf\Redis\Redis;
use Hyperf\WebSocketServer\Sender;

/**
 * @Process(name="WebsocketSubscribe")
 */
#[Process(name: 'WebsocketSubscribe')]
class WebSocketSubscribe extends AbstractProcess
{

    public function handle(): void
    {
        $redis = $this->container->get(Redis::class);
        $sender = $this->container->get(Sender::class);
        $redis->subscribe([
            'message'
        ],function ($redis_raw,$chan,$msg)use ($redis,$sender){
           $data = json_decode($msg,true);
           $app_name = env('APP_NAME');

           switch ($data['type'])
           {
               case 'friend':
                   $key = $app_name.'_user_id_'.$data['content']['to']['id'];
                   // 判断是否连接在当前实例上
                   if (!$redis->exists($key))
                   {
                       return;
                   }
                   $fd = (int)$redis->get($key);
                   $sender->push($fd,json_encode($data['content'],JSON_UNESCAPED_UNICODE));
                   break;
               case 'group':
                   $group_id = $data['content']['to']['id'];
                   //获取所有的群内成员
                   $user_ids = GroupRelation::where('group_id',$group_id)->select([
                       'user_id'
                   ])->get()->toArray();
                   foreach ($user_ids as $relation)
                   {
                       $user_id = $relation['user_id'];

                       // 如果消息是自己发送的,就跳过
                       if ($user_id == $data['content']['from']['id'])
                       {
                            continue;
                       }

                       $key = $app_name.'_user_id_'.$user_id;
                       // 判断是否连接在当前实例上
                       if (!$redis->exists($key))
                       {
                           //如果实例不在当前机子上.就跳过
                           continue;
                       }
                       $fd = (int)$redis->get($key);
                       $sender->push($fd,json_encode($data['content'],JSON_UNESCAPED_UNICODE));
                   }
                   break;
           }
        });
    }
}
