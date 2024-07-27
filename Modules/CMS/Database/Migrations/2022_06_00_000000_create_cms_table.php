<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('com_id')->unsigned()->nullable();
                $table->bigInteger('blog_category_id')->unsigned()->nullable();
                $table->string('title');
                $table->tinyInteger('status')->default(0)->nullable();
                $table->tinyInteger('order');
                $table->integer('created_by');
                $table->softDeletes();
                $table->timestamps();
                //$table->foreign('com_id')->references('id')->on('companies')->onDelete('SET NULL');
                //$table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('CASCADE');
            });
        }

        if (! Schema::hasTable('blog_details')) {
            Schema::create('blog_details', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('blog_id')->unsigned()->nullable();
                $table->string('details');
                $table->integer('order')->nullable();
                $table->tinyInteger('status')->default(0)->nullable();
                $table->softDeletes();
                $table->timestamps();
                //$table->foreign('com_id')->references('id')->on('companies')->onDelete('SET NULL');
                //$table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('CASCADE');
            });
        }



        if (! Schema::hasTable('books')) {
            Schema::create('books', function (Blueprint $table) {
                $table->id();
                $table->string('image')->nullable();
                $table->string('url')->nullable();
                $table->integer('order')->nullable();
                $table->integer('view')->nullable();
                $table->integer('created_by')->nullable();
                $table->tinyInteger('status')->default(0)->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_details');
        Schema::dropIfExists('books');
    }
}
