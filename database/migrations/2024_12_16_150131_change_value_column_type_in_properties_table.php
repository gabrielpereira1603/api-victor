<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeValueColumnTypeInPropertiesTable extends Migration
{

    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('value')->change();
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->decimal('value', 15, 2)->change();
        });
    }
}
