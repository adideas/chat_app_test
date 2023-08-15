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
        if (Schema::hasTable('__chatapp_license__')) {
            return;
        }

        Schema::create('__chatapp_license__', function (Blueprint $table) {
            $table->id('licenseId');
            $table->unsignedInteger('licenseTo');
            $table->bigInteger('cabinetUserId')->unsigned();
            $table->boolean('isUse')->nullable()->unique();
        });

        Schema::table('__chatapp_license__', function (Blueprint $table) {
            $table->foreign('cabinetUserId')
                ->references('cabinetUserId')
                ->on('__chatapp_token__')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('__chatapp_license__');
    }
};
