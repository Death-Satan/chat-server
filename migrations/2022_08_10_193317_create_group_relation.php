<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGroupRelation extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_relation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('group_id')->comment('群组id');
            $table->bigInteger('user_id')->comment('用户id');
            $table->timestamps();
            $table->comment('群组到用户的中间表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_relation');
    }
}
