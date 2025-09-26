<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the enum column to include shipped + delivered + cancelled
        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending','confirmed','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback to the old enum (only pending + confirmed + shipped)
        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending','confirmed','shipped') NOT NULL DEFAULT 'pending'");
    }
};
