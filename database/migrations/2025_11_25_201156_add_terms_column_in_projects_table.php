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
            $table->string('phone')->after('client_name')->nullable();
            $table->longText('post_deployment')->after('client_org')->nullable();
            $table->longText('terms')->after('post_deployment')->nullable();
            $table->longText('declaration')->after('terms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('terms');
            $table->dropColumn('post_deployment');
            $table->dropColumn('declaration');
        });
    }
};
