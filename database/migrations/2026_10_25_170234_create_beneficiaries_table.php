<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();

            // Identitas penerima
            $table->string('name');
            $table->string('nik', 32);
            $table->text('address');
            $table->string('contact')->nullable();

            // Kategori dan kondisi penerima
            $table->string('category');
            $table->text('condition')->nullable();

            // Status penerima
            $table->string('status')->default('Aktif');

            // Informasi tambahan
            $table->date('registered_at')->useCurrent();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};