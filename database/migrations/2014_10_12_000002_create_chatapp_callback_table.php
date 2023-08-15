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
        if (Schema::hasTable('__chatapp_callback__')) {
            return;
        }

        Schema::create('__chatapp_callback__', function (Blueprint $table) {
            $table->bigInteger('licenseId')->unsigned();
            $table->enum('type', [
                'message',
                'messageStatus',
                'chatTag',
                'chatStatus',
                'chatResponsible',
                'chatProducer',
                'chatAccomplice',
                'chatAuditor',
                'chatConversation'
            ]);
            $table->text('url');
        });

        Schema::table('__chatapp_callback__', function (Blueprint $table) {
            $table->foreign('licenseId')
                ->references('licenseId')
                ->on('__chatapp_license__')
                ->onDelete('cascade');

            $table->unique(['licenseId', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('__chatapp_callback__');
    }
};
