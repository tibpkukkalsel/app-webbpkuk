<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_foto', function (Blueprint $table) {
            $table->id('id_foto');
            $table->bigInteger('id_fasilitas')->unsigned();
            $table->string('foto');
            $table->integer('urutan')->default(0);
            $table->tinyInteger('status')->default(1); // 1=aktif, 0=nonaktif
            $table->timestamps();

            $table->foreign('id_fasilitas')
                ->references('id_fasilitas')
                ->on('fasilitas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_foto');
    }
};
