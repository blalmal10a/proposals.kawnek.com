<?php

use App\Models\FeatureGroup;
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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            // Foreign Key to feature_groups table
            $table->foreignIdFor(FeatureGroup::class);

            $table->boolean('is_selected')->default(false);
            $table->boolean('default_selection_value')->nullable();

            $table->boolean('is_required')->default(false);

            // Using json for storing arrays of related feature IDs
            $table->json('required_feature_ids')->nullable();
            $table->json('dependant_feature_ids')->nullable();

            // Cost fields
            $table->decimal('cost', 16, 2)->nullable();
            $table->decimal('yearly_cost', 16, 2)->nullable();
            $table->decimal('monthly_cost', 16, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
