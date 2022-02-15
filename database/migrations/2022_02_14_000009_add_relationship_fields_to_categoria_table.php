<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCategoriaTable extends Migration
{
    public function up()
    {
        Schema::table('categoria', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_5998294')->references('id')->on('users');
        });
    }
}
