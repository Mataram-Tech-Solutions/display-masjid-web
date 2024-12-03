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
        Schema::create('primarydis', function (Blueprint $table) {
            $table->id();
            $table->integer('unique');
            $table->string('name');
            $table->unsignedBigInteger('created_by'); // Kolom imam yang merujuk ke id di tabel ustadz
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by'); // Kolom imam yang merujuk ke id di tabel ustadz
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primarydis');
    }
};
