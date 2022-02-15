<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToInserzionesTable extends Migration
{
    public function up()
    {
        Schema::table('inserziones', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id', 'categoria_fk_5998296')->references('id')->on('categoria');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_5998305')->references('id')->on('users');
        });
    }
}
