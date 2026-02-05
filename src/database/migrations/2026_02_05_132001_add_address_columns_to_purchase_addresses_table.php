<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressColumnsToPurchaseAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_addresses', function (Blueprint $table) {
            $table->string('postcode', 8);
            $table->string('address');
            $table->string('building')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_addresses', function (Blueprint $table) {
            $table->dropColumn(['postcode', 'address', 'building']);
        });
    }
}
