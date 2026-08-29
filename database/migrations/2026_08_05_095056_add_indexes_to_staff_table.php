<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->index('lga_id');
            $table->index('category_id');
            $table->index('agency_id');
            $table->index('expected_date_of_retirement');
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropIndex(['lga_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['agency_id']);
            $table->dropIndex(['expected_date_of_retirement']);
        });
    }
};
