<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 
       // In the migration file
       public function up()
       {
           Schema::create('qibla_searches', function (Blueprint $table) {
               $table->id();
               $table->string('city');
               $table->string('state')->nullable();
               $table->string('country');
               $table->decimal('latitude', 10, 7);
               $table->decimal('longitude', 10, 7);
               $table->decimal('qibla_direction', 5, 2);
               $table->string('slug')->unique();
               $table->timestamps();
           });
       }
           /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qibla_searches');
    }
};
