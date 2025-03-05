<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subdivisions', function (Blueprint $table) {
            $table->string('first_coordinate')->nullable()->after('coordinates');
        });

        Schema::table('blocks', function (Blueprint $table) {
            $table->string('first_coordinate')->nullable()->after('coordinates');
        });

        Schema::table('lands', function (Blueprint $table) {
            $table->string('first_coordinate')->nullable()->after('coordinates');
        });
    }

    public function down(): void
    {
        Schema::table('subdivisions', function (Blueprint $table) {
            $table->dropColumn('first_coordinate');
        });

        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn('first_coordinate');
        });

        Schema::table('lands', function (Blueprint $table) {
            $table->dropColumn('first_coordinate');
        });
    }
};
