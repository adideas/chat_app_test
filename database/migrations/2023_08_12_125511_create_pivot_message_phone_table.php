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
        if (Schema::hasTable('pivot_message_phone')) {
            return;
        }

        Schema::create('pivot_message_phone', function (Blueprint $table) {
            $table->foreignUuid('message_uuid')
                ->references('uuid')
                ->on('messages')
                ->onDelete('cascade');

            $table->foreignUuid('phone_uuid')
                ->references('uuid')
                ->on('phones')
                ->onDelete('cascade');

            $table->string('token_message')->nullable();
            $table->enum('status', ['sent','delivered','viewed','error'])->nullable();
            $table->string('error_message')->nullable();

            $table->unsignedInteger('reserved_at')->nullable();
        });

        Schema::table('pivot_message_phone', function (Blueprint $table) {
            $table->unique(['message_uuid', 'phone_uuid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_message_phone');
    }
};
