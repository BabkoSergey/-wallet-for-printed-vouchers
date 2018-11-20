<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVoucherTypesToVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voucher', function(Blueprint $table)
		{
                    $table->integer('type_id')->unsigned()->nullable();
                    $table->foreign('type_id')->references('id')->on('voucher_types')->onDelete('set null');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('voucher', function(Blueprint $table)
		{
                    $table->dropColumn('type_id');                    
		});
    }
}
