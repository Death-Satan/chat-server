<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @author   Death-Satan
 * @email    death-satan@qq.com
 */
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateApplication extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('application', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name')->comment('应用名称');
            $table->char(100)->comment('应用code');
            $table->text('callback_server')->comment('回调地址');
            $table->tinyInteger('status')->comment('状态 0:不可用 1:正常');
            $table->timestamps();
            $table->comment('系统应用表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application');
    }
}
