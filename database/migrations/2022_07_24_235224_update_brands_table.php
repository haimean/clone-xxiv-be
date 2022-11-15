<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('image_uuid');
            $table->string('logo_uuid');
            $table->string('background_uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('image_uuid');
            $table->dropColumn(['logo_uuid', 'background_uuid']);
        });
    }
};
