<?php

use App\Participant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->longText('permalink')->nullable()->after('division')->comment('Should be the same with slug');
        });

        Participant::whereNull('permalink')
            ->get()
            ->each(function ($participant) {
                $participant->timestamps = false;
                $participant->permalink = route('registration_show', $participant);
                $participant->save();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn('permalink');
        });
    }
};
