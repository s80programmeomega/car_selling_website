@extends('car_template.base')

@section('title', 'Notifications')

@section('content')
<section style="padding: 3rem 0;">
    <div class="container">
        <!-- Header with Actions -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="font-size: 2.5rem; font-weight: bold;">Notifications</h1>

            <div style="display: flex; gap: 0.75rem;">
                @if($notifications->total() > 0)
                    <!-- Bulk Delete Button -->
                    <button id="bulkDeleteBtn" onclick="deleteSelected()" class="btn btn-danger" style="display: none;">
                        Delete Selected
                    </button>

                    <!-- Mark All as Read -->
                    <form action="{{ route('notifications.read', 'all') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Mark All as Read
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="card" style="background: #10b981; color: white; margin-bottom: 1.5rem; border: none;">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($notifications->count() > 0)
            <!-- Bulk Delete Form -->
            <form id="bulkDeleteForm" action="{{ route('notifications.destroyMultiple') }}" method="POST">
                @csrf
                <input type="hidden" name="notification_ids_input" id="notification_ids_input">
            </form>

            <div class="card" style="padding: 0; overflow: hidden;">
                <!-- Select All Header -->
                <div style="padding: 1rem 1.5rem; border-bottom: 2px solid var(--border-color); background: var(--bg-secondary-color);">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin: 0;">
                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" style="width: 18px; height: 18px; cursor: pointer;">
                        <span style="font-weight: 500;">Select All</span>
                    </label>
                </div>

                <!-- Notifications List -->
                @foreach($notifications as $notification)
                    <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color); {{ $notification->read_at ? 'opacity: 0.7;' : 'background: #f0f9ff;' }}">
                        <div style="display: flex; gap: 1rem; align-items: start;">
                            <!-- Checkbox -->
                            <input type="checkbox" value="{{ $notification->id }}" class="notification-checkbox" onchange="updateBulkDeleteButton()" style="width: 18px; height: 18px; margin-top: 0.25rem; cursor: pointer;">

                            <!-- Content -->
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                    @if(!$notification->read_at)
                                        <span style="display: inline-block; width: 8px; height: 8px; background: var(--primary-color); border-radius: 50%; margin-left: 0.5rem;"></span>
                                    @endif
                                </h3>
                                <p style="color: var(--text-muted-color); margin-bottom: 0.75rem; line-height: 1.5;">
                                    {{ Str::limit($notification->data['message'] ?? $notification->data['car_title'] ?? 'No message', 100) }}
                                </p>

                                <!-- Actions -->
                                <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; font-size: 0.875rem;">
                                    <span style="color: var(--text-muted-color);">
                                        <i class="far fa-clock" style="margin-right: 0.25rem;"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>

                                    <a href="{{ route('notifications.show', $notification->id) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                        <i class="fas fa-eye" style="margin-right: 0.25rem;"></i>
                                        View Details
                                    </a>

                                    @if(!$notification->read_at)
                                        <button onclick="markAsRead('{{ $notification->id }}')" style="color: #10b981; background: none; border: none; cursor: pointer; font-weight: 500; padding: 0;">
                                            <i class="fas fa-check" style="margin-right: 0.25rem;"></i>
                                            Mark as Read
                                        </button>
                                    @endif

                                    <button onclick="deleteNotification('{{ $notification->id }}')" style="color: #ef4444; background: none; border: none; cursor: pointer; font-weight: 500; padding: 0;">
                                        <i class="fas fa-trash" style="margin-right: 0.25rem;"></i>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden forms for individual actions -->
                    <form id="markAsReadForm-{{ $notification->id }}" action="{{ route('notifications.read', $notification->id) }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <form id="deleteForm-{{ $notification->id }}" action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 2rem;">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="card" style="padding: 4rem 2rem; text-align: center;">
                <i class="far fa-bell" style="font-size: 4rem; color: var(--text-muted-color); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-muted-color); margin-bottom: 0.5rem;">No notifications</h3>
                <p style="color: var(--text-muted-color);">You're all caught up!</p>
            </div>
        @endif
    </div>
</section>

<script>
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.notification-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
    updateBulkDeleteButton();
}

function updateBulkDeleteButton() {
    const checkboxes = document.querySelectorAll('.notification-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectAllCheckbox = document.getElementById('selectAll');

    if (checkboxes.length > 0) {
        bulkDeleteBtn.style.display = 'inline-block';
        bulkDeleteBtn.innerHTML = `<i class="fas fa-trash" style="margin-right: 0.25rem;"></i> Delete Selected (${checkboxes.length})`;
    } else {
        bulkDeleteBtn.style.display = 'none';
    }

    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.notification-checkbox');
    selectAllCheckbox.checked = allCheckboxes.length > 0 && checkboxes.length === allCheckboxes.length;
}

function deleteSelected() {
    const checkboxes = document.querySelectorAll('.notification-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Please select at least one notification to delete');
        return;
    }

    if (confirm(`Are you sure you want to delete ${checkboxes.length} notification(s)?`)) {
        // Collect selected IDs
        const ids = Array.from(checkboxes).map(cb => cb.value);

        // Create hidden inputs for each ID
        const form = document.getElementById('bulkDeleteForm');
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'notification_ids[]';
            input.value = id;
            form.appendChild(input);
        });

        form.submit();
    }
}

function markAsRead(notificationId) {
    document.getElementById('markAsReadForm-' + notificationId).submit();
}

function deleteNotification(notificationId) {
    if (confirm('Are you sure you want to delete this notification?')) {
        document.getElementById('deleteForm-' + notificationId).submit();
    }
}
</script>
@endsection
