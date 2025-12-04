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
        Schema::table('ads', function (Blueprint $table) {
        DB::statement("ALTER TABLE ads MODIFY COLUMN status ENUM('pending', 'active', 'inactive', 'closed') DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
        DB::statement("ALTER TABLE ads MODIFY COLUMN status ENUM('pending', 'active', 'inactive') DEFAULT 'pending'");
        });
    }
};
