<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_id')->nullable();

            $table->string('name');
            $table->string('color')->nullable();
            $table->string('code');

            $table->enum('status', ['active', 'inactive'])->default('active');


            $table->json('coordinates')->nullable();

            $table->decimal('area', 10, 2)->nullable();

            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lands');
    }
};
