<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_type');
            $table->string('first_name');
            $table->string('middle_name')->nullable($value = true);
            $table->string('last_name');
            $table->string('email_address');
            $table->string('phone_number');
            $table->string('country_id')->nullable($value = true);
            $table->string('state_id')->nullable($value = true);
            $table->string('city_id')->nullable($value = true);
            $table->string('status');
            $table->string('password');
            $table->string('login_token')->nullable($value = true);
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
        Schema::dropIfExists('users');
    }
}
