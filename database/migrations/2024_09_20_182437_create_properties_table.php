<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('photo_url', 255)->nullable();
            $table->string('maps')->nullable();
            $table->decimal('value', 15, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('suites')->default(0)->nullable();
            $table->integer('living_rooms');
            $table->integer('kitchens');
            $table->integer('parking_spaces');
            $table->integer('pools')->default(0)->nullable();
            $table->string('built_area', 255);
            $table->string('land_area', 255);
            $table->foreignId('neighborhood_id')->constrained('neighborhoods')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('state_id')->constrained('states')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
