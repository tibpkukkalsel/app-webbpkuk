<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_hashtag',function(Blueprint $table){

            $table->id();
            $table->unsignedBigInteger('id_post');
            $table->unsignedBigInteger('id_hashtag');
            $table->timestamps();
            $table->foreign('id_post')
                ->references('id_post')
                ->on('post')
                ->cascadeOnDelete();
            $table->foreign('id_hashtag')
                ->references('id_hashtag')
                ->on('hashtag')
                ->cascadeOnDelete();
            $table->unique([
                'id_post',
                'id_hashtag'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_hashtag');
    }
};