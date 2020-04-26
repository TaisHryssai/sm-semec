<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('registration');
            $table->date('admission_at');
            $table->date('termination_at');
            $table->string('secretary');
            $table->string('place');
            $table->string('role');
            $table->bigInteger('servant_id')->unsigned()->index()->default(1);
            $table->foreign('servant_id')
                    ->references('id')
                    ->on('servants')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('contracts');
    }
}
