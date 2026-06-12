<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
        });

        // Generate slugs for existing records
        $blogs = \App\Models\Blog::all();
        foreach ($blogs as $blog) {
            $blog->slug = Str::slug($blog->title) . '-' . $blog->id;
            $blog->save();
        }
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};