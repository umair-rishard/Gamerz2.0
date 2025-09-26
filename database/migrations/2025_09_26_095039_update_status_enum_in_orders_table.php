<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Allow all possible statuses
        DB::statement("ALTER TABLE orders 
            MODIFY COLUMN status ENUM('pending','confirmed','shipped','cancelled','delivered') 
            NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Rollback to original (no cancelled/delivered)
        DB::statement("ALTER TABLE orders 
            MODIFY COLUMN status ENUM('pending','confirmed','shipped') 
            NOT NULL DEFAULT 'pending'");
    }
};
