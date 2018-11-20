<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('voucher','type_id')) {
			Schema::table('voucher', function (Blueprint $table) {
				$table->dropForeign('voucher_type_id_foreign');
				$table->dropColumn('type_id');
			});
		}
		Schema::table('voucher', function(Blueprint $table)
		{
			$table->decimal('price', 8, 2);
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
