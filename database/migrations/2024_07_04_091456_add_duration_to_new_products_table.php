<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('new_products', function (Blueprint $table) {
        $table->integer('duration')->default(1); // Duration in days
    });
}

public function down()
{
    Schema::table('new_products', function (Blueprint $table) {
        $table->dropColumn('duration');
    });
}

};
