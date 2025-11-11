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
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('total_cost')->default(0)->after('client_name');
            $table->decimal('discount_percent')->nullable()->after('total_cost');
            $table->decimal('discount_amount')->nullable()->after('discount_percent');
        });
        Schema::table('features', function (Blueprint $table) {
            $table->decimal('discount_percent')->nullable()->after('cost');
            $table->decimal('discount_amount')->nullable()->after('discount_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
};
