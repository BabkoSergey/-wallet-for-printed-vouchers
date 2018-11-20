<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumsToApikeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('apikeys', 'user_id')){
            Schema::table('apikeys', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }
        
        if (Schema::hasColumn('apikeys', 'status')){
            Schema::table('apikeys', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
        
        if (Schema::hasColumn('apikeys', 'api_host')){
            Schema::table('apikeys', function (Blueprint $table) {
                $table->dropColumn('api_host');
            });
        }
        
        Schema::table('apikeys', function (Blueprint $table) {
            $table->integer('portal_id')->unsigned()->nullable();
            $table->foreign('portal_id')->references('id')->on('portal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apikeys', function (Blueprint $table) {
            $table->dropForeign('apikeys_portal_id_foreign');
            $table->dropColumn('portal_id');
        });
    }
}
