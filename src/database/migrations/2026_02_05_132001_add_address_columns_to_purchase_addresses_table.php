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
            if (!Schema::hasColumn('purchase_addresses', 'postcode')) {
            $table->string('postcode', 8);
        }

        if (!Schema::hasColumn('purchase_addresses', 'address')) {
            $table->string('address');
        }

        if (!Schema::hasColumn('purchase_addresses', 'building')) {
            $table->string('building')->nullable();
        }
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
            if (Schema::hasColumn('purchase_addresses', 'postcode')) {
            $table->dropColumn('postcode');
        }

        if (Schema::hasColumn('purchase_addresses', 'address')) {
            $table->dropColumn('address');
        }

        if (Schema::hasColumn('purchase_addresses', 'building')) {
            $table->dropColumn('building');
        }
        });
    }
}
