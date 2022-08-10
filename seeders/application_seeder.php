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
        \App\Model\Application::create([
            'name' => 'demo',
            'app_code' => \Hyperf\Utils\Str::random(32),
            'callback_server' => 'http://localhost/callback',
        ]);
    }
}
