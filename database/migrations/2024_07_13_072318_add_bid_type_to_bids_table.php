<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBidTypeToBidsTable extends Migration
{
    public function up()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->string('bid_type');
        });
    }

    public function down()
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropColumn('bid_type');
        });
    }
}
