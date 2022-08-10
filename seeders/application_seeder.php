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
        ]);
        $app_id = $application->id;
        $this->create_users($app_id);

    }

    protected function create_users($app_id)
    {
        // 创建用户
        \App\Model\User::create([
            'app_id' => $app_id,
            'account' => \Hyperf\Utils\Str::random(),
            'avatar' => '',
            'login_ip' => '127.0.0.1',
            'login_time' => \Carbon\Carbon::now(),
        ]);
        \App\Model\User::create([
            'app_id' => $app_id,
            'account' => \Hyperf\Utils\Str::random(),
            'avatar' => '',
            'login_ip' => '127.0.0.1',
            'login_time' => \Carbon\Carbon::now(),
        ]);
    }
}
