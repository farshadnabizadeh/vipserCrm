<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_forms', function (Blueprint $table) {
           $table->increments('id');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('email')->nullable();
            $table->date('pickup_date')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('dropoff_location')->nullable();
            $table->string('person')->nullable();
            $table->string('distance')->nullable();
            $table->string('duration')->nullable();
            $table->integer('form_status_id')->unsigned()->nullable();
            $table->foreign('form_status_id')->references('id')
                ->on('form_statuses')
                ->onDelete('cascade');
            $table->timestamp('answered_time')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('booking_forms');
    }
}
