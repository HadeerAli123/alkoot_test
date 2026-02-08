<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // تعديل ads
        Schema::table('ads', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');
        });

        // تعديل details
        Schema::table('details', function (Blueprint $table) {
            $table->dropForeign(['ads_id']);
            $table->foreign('ads_id')
                  ->references('id')
                  ->on('ads')
                  ->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('set null');
        });

        Schema::table('details', function (Blueprint $table) {
            $table->dropForeign(['ads_id']);
            $table->foreign('ads_id')
                  ->references('id')
                  ->on('ads')
                  ->onDelete('set null');
        });

    }
};