<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @author   Death-Satan
 * @email    death-satan@qq.com
 */
use Hyperf\Database\Seeders\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 创建应用
        $application = \App\Model\Application::create([
            'name' => 'demo',
            'app_code' => \Hyperf\Utils\Str::random(32),
            'callback_server' => 'http://localhost/callback',
            'status' => \App\Enums\ApplicationStatus::NORMAL,
            'app_key' => \Hyperf\Utils\Str::random(32),
            'app_secret' => \Hyperf\Utils\Str::random(32),
        ]);
        $app_id = $application->id;
        $this->create_users($app_id);
    }

    // 创建用户
    protected function create_users($app_id)
    {
        // 创建用户
        $user_1 = \App\Model\User::create([
            'app_id' => $app_id,
            'account' => \Hyperf\Utils\Str::random(),
            'avatar' => '',
            'login_ip' => '127.0.0.1',
            'login_time' => \Carbon\Carbon::now(),
        ]);
        $user_2 = \App\Model\User::create([
            'app_id' => $app_id,
            'account' => \Hyperf\Utils\Str::random(),
            'avatar' => '',
            'login_ip' => '127.0.0.1',
            'login_time' => \Carbon\Carbon::now(),
        ]);

        // 创建好友关系
        \App\Model\Friend::create([
            'from_id'=>$user_1->id,
            'to_id'=>$user_2->id,
            'status'=>1,
            'app_id'=>$app_id
        ]);

        //加入群聊
        $group = $this->create_group($app_id);
        \App\Model\GroupRelation::create([
            'group_id'=>$group->id,
            'user_id'=>$user_1->id,
        ]);
        \App\Model\GroupRelation::create([
            'group_id'=>$group->id,
            'user_id'=>$user_2->id,
        ]);
    }

    protected function create_group($app_id){
        $name = 'test';
        $group_code_name  = \Hyperf\Utils\Str::random(32);
        $setting = [];
        $status = 1;
        $creator = 0;
        return  \App\Model\Group::create(compact(
            'name',
            'app_id',
            'group_code_name',
            'setting',
            'status',
            'creator'
        ));
    }
}
