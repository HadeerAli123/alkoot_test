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
      DB::statement("ALTER TABLE social_media MODIFY COLUMN type ENUM('whatsapp','phone','facebook','instagram','snapchat','linkedin','x','website','visit','menu', 'google_Map', 'google_Map_2') NOT NULL");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_media', function (Blueprint $table) {
            //
        });
    }
};
