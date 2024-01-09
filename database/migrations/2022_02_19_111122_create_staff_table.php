<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('form_no');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('name');
            $table->integer('lga_id');
            $table->integer('school_id');
            $table->integer('duty_station')->nullable();
            $table->string('minimum_wage')->nullable();
            $table->integer('gender_id')->nullable();
            $table->integer('marital_status_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('qualification')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('nin')->unique()->nullable();
            $table->integer('lga_of_origin_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('blood_group')->nullable();
            $table->date('date_of_appointment')->nullable();
            $table->date('date_of_last_promotion')->nullable();
            $table->date('expected_date_of_retirement')->nullable();
            $table->integer('status')->nullable();
            $table->integer('cadre')->nullable();
            $table->integer('salary_id')->nullable();
            $table->string('grade_level')->nullable();
            $table->string('salary_grade_level')->nullable();
            $table->decimal('gross_salary')->nullable();
            $table->decimal('net_salary')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->unique()->nullable();
            $table->string('bvn')->unique()->nullable();
            $table->text('address')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->string('next_of_kin_address')->nullable();
            $table->string('next_of_kin_relationship')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('staff');
    }
}
