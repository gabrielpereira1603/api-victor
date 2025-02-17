<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subdivision_id')->nullable();

            $table->string('name');
            $table->string('color')->nullable();
            $table->string('code');

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->json('coordinates')->nullable();

            $table->decimal('area', 10, 2)->nullable();

            $table->foreign('subdivision_id')->references('id')->on('subdivisions')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
