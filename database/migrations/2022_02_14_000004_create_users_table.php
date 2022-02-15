<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('username')->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('address')->nullable();
            $table->string('comune')->nullable();
            $table->string('country')->nullable();
            $table->string('cap')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
