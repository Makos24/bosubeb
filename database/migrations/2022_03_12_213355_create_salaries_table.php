<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method')->nullable();
            $table->integer('grade')->nullable();
            $table->integer('step')->nullable();
            $table->decimal('basic')->nullable();
            $table->decimal('rent')->nullable();
            $table->decimal('transport')->nullable();
            $table->decimal('utility')->nullable();
            $table->decimal('domestic_staff')->nullable();
            $table->decimal('ent')->nullable();
            $table->decimal('meals')->nullable();
            $table->decimal('paye')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('union')->nullable();
            $table->decimal('td')->nullable();
            $table->decimal('gross')->nullable();
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
        Schema::dropIfExists('salaries');
    }
}
