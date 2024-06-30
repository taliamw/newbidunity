<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuctionStatusToNewProductsTable extends Migration
{
    public function up()
    {
        Schema::table('new_products', function (Blueprint $table) {
            $table->string('auction_status')->default('open'); // 'open' or 'closed'
        });
    }

    public function down()
    {
        Schema::table('new_products', function (Blueprint $table) {
            $table->dropColumn('auction_status');
        });
    }
}
