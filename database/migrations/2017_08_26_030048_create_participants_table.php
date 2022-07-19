<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('staff_id');
            $table->string('email');
            $table->text('division')->nullable();
            $table->boolean('member')->default(false);
            $table->string('payment_status')->default('Pending');
            $table->text('payment_details')->nullable();
            $table->datetime('payment_timestamp')->nullable();
            $table->integer('payment_by')->nullable();
            $table->boolean('attend')->default(false);
            $table->datetime('attend_timestamp')->nullable();
            $table->integer('attended_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['staff_id','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
