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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('name')->index();
            $table->string('iso2')->unique();
            $table->string('iso3')->index()->nullable();
            $table->string('iso_numeric')->nullable();
            $table->string('phone_code')->index()->nullable();
            $table->json('languages')->nullable();
            $table->string('wmo')->nullable();
            $table->json('emoji')->nullable();
            $table->boolean('active_flag')->index()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
