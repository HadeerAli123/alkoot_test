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
        Schema::create('excels', function (Blueprint $table) {
            $table->id();
            $table->text('campaign_id')->nullable();
            $table->text('campaign_name')->nullable();
            $table->text('ad_GIcode')->nullable();
            $table->text('ad_Gname')->nullable();
            $table->text('design_id')->nullable();
            $table->text('advertisement_code')->nullable();
            $table->text('advertisement_name')->nullable();
            $table->text('active_status')->nullable();
            $table->text('ad_type')->nullable();
            $table->text('amount_spent')->nullable();
            $table->text('result')->nullable();
            $table->text('result_type')->nullable();
            $table->text('cost_result')->nullable();
            $table->text('cost_result_type')->nullable();
            $table->text('uploaded_impressions')->nullable();
            $table->text('eCPM')->nullable();
            $table->text('clicks')->nullable();
            $table->text('eCPC')->nullable();
            $table->text('app_install')->nullable();
            $table->text('cost_app_install')->nullable();
            $table->text('rate_app_install')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excels');
    }
};
