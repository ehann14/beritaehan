<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada
            if (!Schema::hasColumn('posts', 'review_status')) {
                $table->enum('review_status', ['pending', 'approved', 'rejected'])
                      ->default('approved')
                      ->after('status');
            }
            
            if (!Schema::hasColumn('posts', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('review_status');
            }
            
            if (!Schema::hasColumn('posts', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->after('rejection_reason')
                      ->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('posts', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'reviewed_by')) {
                $table->dropForeign(['reviewed_by']);
            }
            
            $columnsToDrop = ['review_status', 'rejection_reason', 'reviewed_by', 'reviewed_at'];
            
            $existingColumns = [];
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('posts', $column)) {
                    $existingColumns[] = $column;
                }
            }
            
            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });
    }
};