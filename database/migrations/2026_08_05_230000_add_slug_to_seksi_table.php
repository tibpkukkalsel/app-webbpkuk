<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Seksi;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('seksi', 'slug')) {
            Schema::table('seksi', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('seksi');
            });
        }

        // Generate slugs for existing rows
        foreach (Seksi::all() as $seksiItem) {
            if (empty($seksiItem->slug) && !empty($seksiItem->seksi)) {
                $seksiItem->slug = Str::slug($seksiItem->seksi);
                $seksiItem->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('seksi', 'slug')) {
            Schema::table('seksi', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
