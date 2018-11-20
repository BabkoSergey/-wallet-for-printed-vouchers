<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttachUserToResellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
		{
                    $table->integer('reseller_id')->unsigned()->nullable();
                    $table->foreign('reseller_id')->references('id')->on('reseller')->onDelete('set null');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_reseller_id_foreign');
             $table->dropColumn('reseller_id');
        });        
    }
}
