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
            $table->string('photo_url')->nullable();
            $table->string('maps')->nullable();
            $table->decimal('value', 10, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('suites')->default(0);
            $table->integer('parking_spaces');
            $table->integer('living_rooms');
            $table->integer('kitchens');
            $table->boolean('has_pool')->default(false);
            $table->integer('pool_size')->default(0);
            $table->decimal('built_area', 8, 2);
            $table->decimal('land_area', 8, 2);
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
