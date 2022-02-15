<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInserzionesTable extends Migration
{
    public function up()
    {
        Schema::create('inserziones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('broker');
            $table->decimal('fondo_iniziale', 15, 2);
            $table->decimal('fondo_finale', 15, 2);
            $table->float('percentage', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
