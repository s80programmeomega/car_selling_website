<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('maker_id')->constrained()->onDelete('restrict');
            $table->foreignId('model_id')->constrained('car_models')->onDelete('restrict');
            $table->foreignId('car_type_id')->constrained()->onDelete('restrict');
            $table->foreignId('fuel_type_id')->constrained()->onDelete('restrict');
            $table->foreignId('state_id')->constrained()->onDelete('restrict');
            $table->foreignId('city_id')->constrained()->onDelete('restrict');
            $table->year('year');
            $table->decimal('price', 10, 2);
            $table->integer('mileage')->nullable();
            $table->string('vin_code')->unique()->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('published')->default(false);
            $table->boolean('featured')->default(false);

            // Indexes for better search performance
            $table->index(['maker_id', 'model_id']);
            $table->index(['state_id', 'city_id']);
            $table->index(['car_type_id', 'fuel_type_id']);
            $table->index(['price', 'year']);
            $table->index('published');
            $table->auditable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
