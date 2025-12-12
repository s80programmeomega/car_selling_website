<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Notification Preferences</h2>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-4">
            <div class="space-y-3">
                <h3 class="font-medium text-gray-900">Email Notifications</h3>

                <label class="flex items-center">
                    <input type="checkbox" wire:model="notify_inquiry_received" class="rounded border-gray-300">
                    <span class="ml-2">Inquiry received on my cars</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" wire:model="notify_inquiry_response" class="rounded border-gray-300">
                    <span class="ml-2">Response to my inquiries</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" wire:model="notify_favorite_update" class="rounded border-gray-300">
                    <span class="ml-2">Updates on favorite cars (price drops, sold)</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" wire:model="notify_review_received" class="rounded border-gray-300">
                    <span class="ml-2">New reviews received</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" wire:model="notify_car_sold" class="rounded border-gray-300">
                    <span class="ml-2">When my car is sold</span>
                </label>
            </div>

            <div class="border-t pt-4 space-y-3">
                <h3 class="font-medium text-gray-900">Other Preferences</h3>

                <label class="flex items-center">
                    <input type="checkbox" wire:model="notify_in_app" class="rounded border-gray-300">
                    <span class="ml-2">In-app notifications</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" wire:model="receive_email_digest" class="rounded border-gray-300">
                    <span class="ml-2">Weekly email digest</span>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Save Preferences
                </button>
            </div>
        </form>
    </div>
</div>
