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
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->tinyInteger('gender')->unsigned()->nullable()->comment('O for Female, 1 for Male, 2 for Rather not say');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('type', 30)->default('Admin');
            $table->string('status', 30)->default(\App\Models\User::STATUS_ACTIVE);
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
