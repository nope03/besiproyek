<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Identitas
            $table->string('name', 150);
            $table->string('slug', 120)->unique();
            $table->string('category', 80)->index();
            $table->string('icon', 10)->nullable();
            $table->string('subtitle', 255);

            // Deskripsi utama
            $table->text('intro');
            $table->text('pengertian');
            $table->text('kesimpulan');
            $table->string('ukuran_intro', 500)->nullable();

            // JSON fields
            $table->json('fungsi');       // [{judul, isi}, ...]
            $table->json('jenis');        // [{nama, deskripsi}, ...]
            $table->json('keunggulan');   // ["string", ...]
            $table->json('tabel_header'); // ["col1", "col2", ...]
            $table->json('tabel_data');   // [["val1","val2",...], ...]
            $table->json('spesifikasi');  // {"key": "value", ...}

            // Status
            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};