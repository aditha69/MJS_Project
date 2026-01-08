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
        Schema::create('queues', function (Blueprint $table) {
    $table->id();

    $table->foreignId('pasiens_id')->constrained('pasiens')->cascadeOnDelete();
    $table->foreignId('dokters_id')->constrained('dokters')->cascadeOnDelete();

    $table->integer('queue_number');
    $table->date('queue_date');
    $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
