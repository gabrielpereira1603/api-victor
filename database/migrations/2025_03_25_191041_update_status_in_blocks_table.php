<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            // Alterando a enumeração do campo 'status'
            $table->enum('status', ['disponivel', 'reservado', 'indisponivel'])->default('disponivel')->change();
        });
    }

    public function down(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            // Revertendo para os valores anteriores
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }
};
