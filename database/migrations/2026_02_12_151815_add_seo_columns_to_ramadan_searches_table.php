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
        // For ramadan_searches - check if columns exist first
        Schema::table('ramadan_searches', function (Blueprint $table) {
            if (!Schema::hasColumn('ramadan_searches', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('ramadan_searches', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('ramadan_searches', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('ramadan_searches', 'main_description')) {
                $table->text('main_description')->nullable()->after('meta_keywords');
            }
        });

        // For qibla_searches - add columns if they don't exist
        if (Schema::hasTable('qibla_searches')) {
            Schema::table('qibla_searches', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop columns from ramadan_searches if they exist
        Schema::table('ramadan_searches', function (Blueprint $table) {
            $columns = ['meta_title', 'meta_description', 'meta_keywords', 'main_description'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('ramadan_searches', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        // Drop columns from qibla_searches if they exist
        if (Schema::hasTable('qibla_searches')) {
            Schema::table('qibla_searches', function (Blueprint $table) {
                $columns = ['meta_title', 'meta_description', 'meta_keywords', 'main_description'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('qibla_searches', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};