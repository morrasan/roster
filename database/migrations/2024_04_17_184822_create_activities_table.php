<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('rev')->nullable();
            $table->string('dc')->nullable();
            $table->string('check_in_l')->nullable();
            $table->string('check_in_z')->nullable();
            $table->string('check_out_l')->nullable();
            $table->string('check_out_z')->nullable();
            $table->string('activity')->index();
            $table->string('remark')->nullable();
            $table->string('from')->nullable()->index();
            $table->string('std_l')->nullable();
            $table->string('std_z')->nullable();
            $table->string('to')->nullable();
            $table->string('sta_l')->nullable();
            $table->string('sta_z')->nullable();
            $table->string('ac_hotel')->nullable();
            $table->string('blh')->nullable();
            $table->string('flight_time')->nullable();
            $table->string('night_time')->nullable();
            $table->string('dur')->nullable();
            $table->string('ext')->nullable();
            $table->string('pax_booked')->nullable();
            $table->string('acreg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
