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
        Schema::create(config('dbtables.users', 'users'), function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            // $table->boolean('is_email_verified')->index()->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_code', 10)->nullable();
            $table->string('phone', 20)->nullable();
            // $table->boolean('is_phone_verified')->index()->default(false);
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('address')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('currency', 4)->nullable();
            $table->date('dob')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('referral', 36)->index()->nullable();
            $table->boolean('active_flag')->index()->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['phone_code', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('dbtables.users', 'users'));
    }
};
