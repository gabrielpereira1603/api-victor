<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->string('file_name');
            $table->string('file_type');
        });
    }

    public function down()
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->dropColumn(['file_name', 'file_type']);
        });
    }
};
