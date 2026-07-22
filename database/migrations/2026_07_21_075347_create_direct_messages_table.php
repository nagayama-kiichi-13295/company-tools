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
        Schema::create('direct_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sender_id')      // 送信者
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('receiver_id')    // 受信者
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('body');
            $table->timestamp('read_at')->nullable();   // 既読日時

            $table->timestamps();

            $table->index(['sender_id', 'receiver_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direct_messages');
    }
};
