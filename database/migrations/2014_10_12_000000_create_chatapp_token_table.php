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
        Schema::hasTable('__chatapp_token__') ?: Schema::create('__chatapp_token__', function (Blueprint $table) {
            $table->id('cabinetUserId');
            $table->text('accessToken');
            $table->unsignedInteger('accessTokenEndTime');
            $table->text('refreshToken');
            $table->unsignedInteger('refreshTokenEndTime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('__chatapp_token__');
    }
};
