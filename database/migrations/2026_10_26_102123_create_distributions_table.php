<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();

            // Informasi penyaluran
            $table->date('distribution_date');
            $table->foreignId('beneficiary_id')
                ->constrained('beneficiaries')
                ->restrictOnDelete();

            // Jenis dan nilai bantuan
            $table->string('assistance_type');
            $table->decimal('amount', 15, 2);

            // Sumber donasi
            $table->foreignId('donation_id')
                ->nullable()
                ->constrained('donations')
                ->nullOnDelete();

            // Status dan catatan
            $table->string('status')->default('Disalurkan');
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};