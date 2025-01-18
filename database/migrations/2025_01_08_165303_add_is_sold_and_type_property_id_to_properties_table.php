<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->boolean('is_sold')->default(false)->after('pools');

            $table->foreignId('type_property_id')
                ->nullable()
                ->constrained('type_properties')
                ->onDelete('set null')
                ->after('state_id');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('is_sold');
            $table->dropForeign(['type_property_id']);
            $table->dropColumn('type_property_id');
        });
    }
};
