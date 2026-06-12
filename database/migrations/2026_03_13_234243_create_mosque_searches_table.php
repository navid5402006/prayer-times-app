<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mosque_searches', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('timezone')->nullable();
            $table->string('slug')->unique();
            
            // SEO Meta Fields
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->longText('main_description')->nullable();
            
            // Stats
            $table->integer('total_mosques')->default(0);
            $table->timestamp('last_fetched_at')->nullable();
            
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['city', 'country']);
            $table->index('slug');
            $table->index('country');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mosque_searches');
    }
};