<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Tambahkan kolom user_id jika belum ada
            if (!Schema::hasColumn('comments', 'user_id')) {
                $table->foreignId('user_id')
                      ->after('id')
                      ->nullable() // nullable dulu untuk data existing
                      ->constrained()
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};