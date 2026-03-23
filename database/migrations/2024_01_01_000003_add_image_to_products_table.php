<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Jalankan migration ini jika tabel products SUDAH ADA
 * dan hanya perlu menambahkan kolom image.
 *
 * php artisan migrate (jika belum pernah migrate)
 * ATAU
 * php artisan migrate --path=database/migrations/2024_01_01_000003_add_image_to_products_table.php
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'image')) {
                // Tambahkan setelah kolom subtitle
                $table->string('image', 255)->nullable()->after('subtitle');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};