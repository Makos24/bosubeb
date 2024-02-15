<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grade_benefits', function (Blueprint $table) {
            $table->id();
            $table->integer('salary_item_id');
            $table->integer('salary_structure_id');
            $table->integer('grade');
            $table->integer('step');
            $table->decimal('amount');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_benefits');
    }
};
