<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResellerUserToVoucherTable extends Migration
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
                    $table->integer('reseller_id')->unsigned()->nullable();
                    $table->foreign('reseller_id')->references('id')->on('reseller')->onDelete('set null');
                    
                    $table->integer('seller_id')->unsigned()->nullable();
                    $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');
                    
                    $table->integer('user_id')->unsigned()->nullable();                    
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
