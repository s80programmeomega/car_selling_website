<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This table stores user subscriptions for email notifications
     * about new cars, price drops, and other updates.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Subscription type: 'new_cars', 'price_drops', 'newsletter', 'similar_cars'
            $table->string('type');

            // Subscription status
            $table->boolean('is_active')->default(true);

            // Frequency: 'instant', 'daily', 'weekly'
            $table->string('frequency')->default('daily');

            // Filters stored as JSON (maker_id, model_id, price_min, price_max, state_id, city_id)
            $table->json('filters')->nullable();

            // Last notification sent timestamp
            $table->timestamp('last_sent_at')->nullable();

            // Unsubscribe token for one-click unsubscribe
            $table->string('unsubscribe_token')->unique();

            $table->auditable();

            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'type', 'is_active']);
            $table->index('unsubscribe_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
