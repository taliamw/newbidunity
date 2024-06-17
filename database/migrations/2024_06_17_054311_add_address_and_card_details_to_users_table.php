<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressAndCardDetailsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('card_last4')->nullable();
            $table->string('card_brand')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('card_last4');
            $table->dropColumn('card_brand');
        });
    }
}
