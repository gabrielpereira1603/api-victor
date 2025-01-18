<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->text('maps')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('maps', 255)->change();
        });
    }
};
