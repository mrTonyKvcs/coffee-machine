<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_service')->default(0);
            $table->timestamps();
        });

        Schema::create('machine_product', function (Blueprint $table) {
            $table->integer('machine_id');
            $table->integer('product_id');
            $table->primary(['machine_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machines');
        Schema::dropIfExists('machine_product');
    }
}
