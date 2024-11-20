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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->time('waktu_adzan');
            $table->time('waktu_iqomah');
            $table->integer('jeda_adziq')->nullable();
            $table->boolean('audmurstat')->default(0);
            $table->boolean('audstat')->default(0);
            $table->unsignedBigInteger('audmur');
            $table->foreign('audmur')->references('id')->on('audio')->onDelete('cascade');
            $table->unsignedBigInteger('audio');
            $table->foreign('audio')->references('id')->on('audio')->onDelete('cascade');
            $table->unsignedBigInteger('imam');
            $table->foreign('imam')->references('id')->on('ustadz')->onDelete('cascade');
            $table->unsignedBigInteger('khatib');
            $table->foreign('khatib')->references('id')->on('ustadz')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
