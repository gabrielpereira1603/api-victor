<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('lands', function (Blueprint $table) {
            $table->decimal('front_size', 10, 2)->nullable()->after('area');
            $table->decimal('background_size', 10, 2)->nullable()->after('front_size');
        });

    }

    public function down(): void
    {
        Schema::table('lands', function (Blueprint $table) {
            $table->dropColumn('front_size');
            $table->dropColumn('background_size');
        });
    }
};
