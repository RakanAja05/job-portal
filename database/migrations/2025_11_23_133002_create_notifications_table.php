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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Admin yang akan menerima notifikasi
            $table->foreignId('application_id')->constrained()->onDelete('cascade'); // Lamaran yang dimaksud
            $table->string('type')->default('new_application'); // Tipe notifikasi
            $table->string('title'); // Judul notifikasi
            $table->text('message'); // Isi pesan notifikasi
            $table->boolean('is_read')->default(false); // Status sudah dibaca atau belum
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
