<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // 'type' kolonu eklendi
            $table->text('content');
            $table->string('attachment')->nullable(); // Dosya/Resim için alan
            $table->json('data')->nullable();
            $table->timestamps();

            // Eğer mesajların sıralanması için index gerekiyorsa
            $table->index('created_at');

        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
