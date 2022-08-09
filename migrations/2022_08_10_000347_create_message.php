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

class CreateMessage extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('message', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('app_id')->comment('应用id');
            $table->bigInteger('to_id')->comment('接收者');
            $table->bigInteger('form_id')->comment('发送者');
            $table->tinyInteger('msg_type')->comment('消息分类');
            $table->tinyInteger('type')->comment('消息类型');
            $table->json('content')->comment('消息内容');
            $table->timestamps();
            $table->comment('消息表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message');
    }
}
