<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prayer_searches', function (Blueprint $table) {

            // SEO FIELDS (OPTIONAL)
            $table->string('meta_title')->nullable()->after('timezone');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');

            // CONTENT
            $table->longText('description')->nullable()->after('meta_keywords');

            // IMAGE (OPTIONAL)
            $table->string('image')->nullable()->after('description');

            // ADMIN STATUS
            $table->boolean('is_updated')->default(0)->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('prayer_searches', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_keywords',
                'description',
                'image',
                'is_updated',
            ]);
        });
    }
};
