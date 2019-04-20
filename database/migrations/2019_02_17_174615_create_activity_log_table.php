<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('activitylog.table_name'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->string('subject_id',16)->nullable();
            $table->string('subject_type')->nullable();
            $table->string('causer_id',16)->nullable();
            $table->string('causer_type')->nullable();
            $table->text('properties')->nullable();
            $table->timestamps();

            $table->index('log_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('activitylog.table_name'));
    }
}
