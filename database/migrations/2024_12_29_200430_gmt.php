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
        Schema::create('gmt', function (Blueprint $table) {
            $table->id(); // ID Primary Key Auto Increment
            $table->string('wilayah');
            $table->integer('gmt_selisih');
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
