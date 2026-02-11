<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemIdToPurchaseAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_addresses', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_addresses', 'item_id')) {
            $table->foreignId('item_id')
                ->after('user_id')
                ->constrained()
                ->cascadeOnDelete();
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
            if (Schema::hasColumn('purchase_addresses', 'item_id')) {
            $table->dropForeign(['item_id']);
            $table->dropColumn('item_id');
        }
        });
    }
}
