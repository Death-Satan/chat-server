<?php

declare(strict_types=1);

namespace App\Process;

use Hyperf\Process\AbstractProcess;
use Hyperf\Process\Annotation\Process;
use Hyperf\Redis\Redis;

/**
 * @Process(name="WebsocketSubscribe")
 */
#[Process(name: 'WebsocketSubscribe')]
class WebSocketSubscribe extends AbstractProcess
{

    public function handle(): void
    {
        $redis = $this->container->get(Redis::class);
        $redis->subscribe([
            'message'
        ],function ($redis,$chan,$msg){
            var_dump($redis,$chan,$msg);
        });
    }
}
