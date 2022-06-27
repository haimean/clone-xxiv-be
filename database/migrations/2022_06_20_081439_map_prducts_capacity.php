<?php

use App\Models\Capacity;
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
        Schema::create('map_porducts_capacity', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Capacity::class);
            $table->foreignIdFor(Product::class);
            $table->integer('quantity')->default(0);
            $table->float('price')->default(0);          
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
        Schema::dropIfExists('map_porducts_capacity');
    }
};
