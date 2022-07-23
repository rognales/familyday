<?php

use App\User;
use App\Participant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration 
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount')->comment('Payment amount');
            $table->string('reference')->comment('Payment reference number');
            $table->timestamp('paid_at');
            $table->string('filename')->comment('Actual filename uploaded');
            $table->foreignIdFor(Participant::class)->nullable();
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
        Schema::dropIfExists('uploads');
    }
};
