<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('regular_price', 10, 2);
            $table->decimal('min_sale_quantity', 10, 2);
            $table->decimal('discount_persentige', 10, 2)->default(0);
            $table->decimal('discount_flat', 10, 2)->default(0);
            $table->decimal('total_discount_persentige', 10, 2)->default(0);
            $table->decimal('present_sale_price', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->integer('unit_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('trash')->length(1)->unsigned()->default(0);
            $table->string('slug');
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
}
