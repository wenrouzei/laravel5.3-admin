<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('权限名');
            $table->string('label')->comment('权限解释名称');
            $table->string('description')->comment('描述与备注');
            $table->tinyInteger('cid')->comment('级别');
            $table->string('icon')->comment('图标')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('article');
    }
}
