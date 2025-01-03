<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('writtens')->nullable()->default(null)->after('parking_spaces');
            $table->string('ramps')->nullable()->default(null)->after('writtens');
            $table->string('machine_rooms')->nullable()->default(null)->after('ramps');
            $table->text('description')->nullable()->after('machine_rooms');
            $table->string('file_name')->nullable()->default(null)->after('photo_url');
            $table->string('file_type')->nullable()->default(null)->after('file_name');
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['writtens', 'ramps', 'machine_rooms', 'description', 'file_name', 'file_type']);
        });
    }
};
