<?php

use Illuminate\Database\Migrations\Migration;

class AddKeyTypeToExistingKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	DB::update("UPDATE `keys`
		SET key_type_id = '1'
		WHERE key_type_id is null
	");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
