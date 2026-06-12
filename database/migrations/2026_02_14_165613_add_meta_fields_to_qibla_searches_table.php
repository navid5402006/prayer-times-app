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
        Schema::table('qibla_searches', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('qibla_searches', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('slug');
            }
            
            if (!Schema::hasColumn('qibla_searches', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            
            if (!Schema::hasColumn('qibla_searches', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
            
            if (!Schema::hasColumn('qibla_searches', 'main_description')) {
                $table->text('main_description')->nullable()->after('meta_keywords');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qibla_searches', function (Blueprint $table) {
            $columns = ['meta_title', 'meta_description', 'meta_keywords', 'main_description'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('qibla_searches', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};