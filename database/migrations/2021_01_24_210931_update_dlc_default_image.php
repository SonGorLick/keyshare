<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDlcDefaultImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dlcs', function (Blueprint $table) {
            $table->string('image')->default('/images/gamedefault.png')->change();

            DB::update("UPDATE dlcs
                SET image = CONCAT('/', image) 
                WHERE image NOT LIKE 'https://%'
            ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dlcs', function (Blueprint $table) {
            $table->string('image')->default('images/gamedefault.png')->change();
        });
    }
}
