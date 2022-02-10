<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('category_id')->nullable();
            $table->string('subcategory_id')->nullable();
            $table->string('title');
            $table->string('description');
            $table->string('crossout_price');
            $table->string('price');
            $table->string('difficulty');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->boolean('is_approved')->default(False);
            $table->enum('status', ['inactive','active']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
