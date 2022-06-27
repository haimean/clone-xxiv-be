<?php

use App\Models\Brands;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->srting('title');
            $table->set('sex', ['Male', 'Female', 'Oversex']);
            $table->srting('content');
            $table->longText('description');
            $table->foreignIdFor(Brands::class);
            $table->integer('time_smell');
            $table->integer('age');
            $table->integer('spring');
            $table->integer('summer');
            $table->integer('fall');
            $table->integer('winter');
            $table->integer('day');
            $table->integer('night');
            $table->year('published_at');
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
        Schema::dropIfExists('products');
    }
};
