<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenstratujuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmRenstraTujuan', function (Blueprint $table) {
            $table->string('RenstraTujuanID',19);
            $table->string('RenstraMisiID',19);
            $table->string('Kd_RenstraTujuan',4);
            $table->string('Nm_RenstraTujuan');           
            $table->string('Descr')->nullable();
            $table->year('TA');
            $table->boolean('Locked')->default(0);

            $table->timestamps();

            $table->primary('RenstraTujuanID');

            $table->index('RenstraMisiID');

            $table->foreign('RenstraMisiID')
                    ->references('RenstraMisiID')
                    ->on('tmRenstraMisi')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmRenstraTujuan');
    }
}
