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
        Schema::table('posts', function (Blueprint $table) {
            // Tambahkan kolom category_id dengan relasi ke tabel categories
            $table->foreignId('category_id')
                  ->nullable() // boleh kosong
                  ->constrained('categories') // relasi ke tabel categories
                  ->onDelete('set null'); // kalau kategori dihapus, kolom jadi null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Hapus relasi dan kolom jika rollback
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
