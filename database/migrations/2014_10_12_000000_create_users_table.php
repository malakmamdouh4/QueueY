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
            $table->string('fullName')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('title')->nullable();
            $table->string('busName')->nullable();
            $table->string('busCategory')->nullable();
            $table->string('busPhone')->nullable();
            $table->string('busWebsite')->nullable();
            $table->string('busEmail')->nullable();
            $table->string('role')->nullable()->default(null);
            $table->string('busUpgrade')->nullable()->default(0);
            $table->string('avatar')->nullable();
            $table->string('code')->nullable()->default(1111);
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
        Schema::dropIfExists('users');
    }
}
