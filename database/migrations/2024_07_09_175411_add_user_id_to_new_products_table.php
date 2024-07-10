<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToNewProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_products', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('status');

            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_products', function (Blueprint $table) {
            // Drop foreign key first to avoid errors
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
