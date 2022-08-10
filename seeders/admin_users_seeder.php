<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @author   Death-Satan
 * @email    death-satan@qq.com
 */
use Hyperf\Database\Seeders\Seeder;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $halt = env('HASH_HALT');
        \App\Model\AdminUser::create([
            'username' => 'admin',
            'password' => md5($halt . '123456'),
        ]);
    }
}
