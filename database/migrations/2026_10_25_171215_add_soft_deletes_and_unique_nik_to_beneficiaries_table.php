<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->softDeletes();
            $table->unique('nik', 'beneficiaries_nik_unique');
        });
    }

    public function down(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropUnique('beneficiaries_nik_unique');
            $table->dropSoftDeletes();
        });
    }
};