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

class CreateFriend extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('friend', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('app_id')->comment('应用id');
            $table->bigInteger('from_id')->comment('申请者id');
            $table->bigInteger('to_id')->comment('被申请者id');
            $table->tinyInteger('status')->comment('状态');
            $table->timestamps();
            $table->comment('好友关系表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend');
    }
}
