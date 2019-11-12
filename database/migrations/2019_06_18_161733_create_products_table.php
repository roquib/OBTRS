<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('group_id')->nullable();
            $table->integer('category_id');
            $table->double('price');
            $table->integer('qty');
            $table->integer('offer')->default(0);
            $table->string('isbn_no')->nullable();
            $table->integer('user_id')->default(1);
            $table->integer('author_id');
            $table->integer('admin_id');
            $table->tinyInteger('publication_id')->nullable();
            $table->integer('publication_status')->nullable();
            $table->string('image');
            $table->text('description')->nullable();
            $table->rememberToken();
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
