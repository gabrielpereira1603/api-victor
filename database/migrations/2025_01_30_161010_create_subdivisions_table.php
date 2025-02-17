<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subdivisions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('neighborhood_id')->nullable();

            $table->string('name')->nullable();

            $table->json('coordinates')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->decimal('area', 10, 2)->nullable();
            $table->string('color')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subdivisions');
    }
};
