<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Kategori;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('kategori', 'slug')) {
            Schema::table('kategori', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('kategori');
            });
        }

        // Populate slug for existing categories
        foreach (Kategori::all() as $item) {
            if (empty($item->slug) && !empty($item->kategori)) {
                $item->slug = Str::slug($item->kategori);
                $item->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('kategori', 'slug')) {
            Schema::table('kategori', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
