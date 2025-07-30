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
        Schema::table(table: 'addresses', callback: function (Blueprint $table): void {
            $table->string(column: 'rajaongkir_subdistrict_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(table: 'addresses', callback: function (Blueprint $table): void {
            $table->dropColumn('rajaongkir_subdistrict_id');
        });
    }
};
