<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('astronomis', function (Blueprint $table) {
            $table->id(); // ID Primary Key Auto Increment
            $table->string('latitude')->comment('Garis Lintang');
            $table->string('longitude')->comment('Garis Bujur');
            $table->integer('ketinggian_laut')->default(0)->comment('Ketinggian Laut (meter)');
            $table->integer('sudut_fajarsenja')->comment('Sudut Fajar dan Senja (derajat)');
            $table->integer('sudut_malamsenja')->comment('Sudut Malam dan Senja (derajat)');
            $table->string('gmt', 3)->default('+7')->comment('Zona Waktu (GMT)');
            $table->timestamps(); // Created_At & Updated_At
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
