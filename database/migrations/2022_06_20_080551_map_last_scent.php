<?php

use App\Models\Fragrance;
use App\Models\Product;
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
        Schema::create('map_main_scent', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fragrance::class);
            $table->foreignIdFor(Product::class);
            $table->timestamps();
        });
        Schema::create('map_top_scent', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fragrance::class);
            $table->foreignIdFor(Product::class);
            $table->timestamps();
        });
        Schema::create('map_middle_scent', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fragrance::class);
            $table->foreignIdFor(Product::class);
            $table->timestamps();
        });
        Schema::create('map_last_scent', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fragrance::class);
            $table->foreignIdFor(Product::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('map_main_scent');
        Schema::dropIfExists('map_top_scent');
        Schema::dropIfExists('map_middle_scent');
        Schema::dropIfExists('map_last_scent');
    }
};
