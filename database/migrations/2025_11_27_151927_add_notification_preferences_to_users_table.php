<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Add notification preferences to users table
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Email notification preferences
            $table->boolean('notify_inquiry_received')->default(true)->after('address');
            $table->boolean('notify_inquiry_response')->default(true)->after('notify_inquiry_received');
            $table->boolean('notify_favorite_update')->default(true)->after('notify_inquiry_response');
            $table->boolean('notify_review_received')->default(true)->after('notify_favorite_update');
            $table->boolean('notify_car_sold')->default(true)->after('notify_review_received');

            // In-app notification preferences
            $table->boolean('notify_in_app')->default(true)->after('notify_car_sold');

            // Email digest preference
            $table->boolean('receive_email_digest')->default(true)->after('notify_in_app');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'notify_inquiry_received',
                'notify_inquiry_response',
                'notify_favorite_update',
                'notify_review_received',
                'notify_car_sold',
                'notify_in_app',
                'receive_email_digest',
            ]);
        });
    }
};
