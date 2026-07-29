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
        Schema::create('video', function (Blueprint $table) {
            $table->id('id_video');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('youtube_id');
            $table->text('ringkasan')->nullable();
            $table->unsignedBigInteger('id_kategori');
            $table->tinyInteger('status')->default(0);
            $table->integer('view_count')->default(0);
            $table->unsignedBigInteger('id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video');
    }
};
