<?php

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
        Schema::table('dependants', function (Blueprint $table) {
            $table->boolean('member')->after('participant_id')->default(false);
            $table->integer('price')->after('member')->nullable()->comment('Value is in Sen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dependants', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
