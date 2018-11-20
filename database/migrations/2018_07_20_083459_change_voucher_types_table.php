<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVoucherTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
		if (Schema::hasColumn('voucher_types','name')) {
			Schema::table('voucher_types', function (Blueprint $table) {
				$table->dropColumn('name');
			});
		}

		if (Schema::hasColumn('voucher_types','validity')) {
			Schema::table('voucher_types', function (Blueprint $table) {
				$table->dropColumn('validity');
			});
		}
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
