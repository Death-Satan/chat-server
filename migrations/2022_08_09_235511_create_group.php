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

class CreateGroup extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('app_id')->comment('应用id');
            $table->char('name', 100)->comment('群组名称');
            $table->char('group_code_name', 100)->comment('群组code');
            $table->json('setting')->comment('其他设置');
            $table->tinyInteger('status')->comment('状态');
            $table->timestamps();
            $table->comment('群组表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group');
    }
}
