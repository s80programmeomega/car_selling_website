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
        Schema::table('cars', function (Blueprint $table) {
            $table->string('transmission')->after('fuel_type_id');
            $table->string('color')->nullable()->after('transmission');
            $table->string('interior_color')->nullable()->after('color');
            $table->tinyInteger('doors')->nullable()->after('interior_color');
            $table->tinyInteger('seats')->nullable()->after('doors');
            $table->string('engine_size')->nullable()->after('seats');
            $table->enum('condition', ['new', 'used', 'certified'])->default('used')->after('engine_size');
            $table->boolean('accident_history')->default(false)->after('condition');
            $table->tinyInteger('number_of_owners')->nullable()->after('accident_history');
            $table->unsignedInteger('view_count')->default(0)->after('featured');
            $table->timestamp('sold_at')->nullable()->after('view_count');
            $table->enum('status', ['available', 'pending', 'sold'])->default('available')->after('sold_at');

            $table->index('status');
            $table->index('transmission');
            $table->index('condition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'transmission', 'color', 'interior_color', 'doors', 'seats',
                'engine_size', 'condition', 'accident_history', 'number_of_owners',
                'view_count', 'sold_at', 'status'
            ]);
        });
    }
};
