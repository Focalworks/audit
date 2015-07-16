<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersionInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('version_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id');
            $table->string('content_type',255);
            $table->string('revision_no',100);
            $table->integer('user_id');
            $table->text('data');
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
        Schema::drop('version_info');
    }
}
