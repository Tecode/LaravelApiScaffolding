<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link', function (Blueprint $table) {
            $table->engine ='MyISAM';
            $table->increments('link_id');
            $table->string('link_name')->default('')->comment("//链接名称");
            $table->string('link_tittle')->default('')->comment("//描述");
            $table->integer('link_order')->default('0')->comment("//排序");
            $table->string('link_url')->default('')->comment("//链接地址");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('link');
    }
}
