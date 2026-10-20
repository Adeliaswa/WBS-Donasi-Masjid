<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name')->nullable();
            $table->date('donation_date');
            $table->decimal('amount', 15, 2);
            $table->string('channel');
            $table->string('payment_method');

            // Kategori donasi disimpan sebagai teks
            $table->string('category');

            $table->text('notes')->nullable();
            $table->string('verification_status');
            $table->string('proof_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};