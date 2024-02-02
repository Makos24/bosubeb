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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->decimal('amount', 10, 2); // Loan amount
            $table->decimal('remaining_balance', 10, 2); // Remaining balance after repayments
            $table->unsignedTinyInteger('status')->default(0); // 0: Pending, 1: Approved, 2: Rejected
            $table->timestamps();
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
