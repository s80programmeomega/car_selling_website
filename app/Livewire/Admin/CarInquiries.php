<?php

namespace App\Livewire\Admin;

use App\Models\CarInquiry;
use Livewire\Component;
use Livewire\WithPagination;

class CarInquiries extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, unread, read

    public function markAsRead($id)
    {
        CarInquiry::findOrFail($id)->update(['is_read' => true]);
        session()->flash('message', 'Inquiry marked as read.');
    }

    public function markAsUnread($id)
    {
        CarInquiry::findOrFail($id)->update(['is_read' => false]);
        session()->flash('message', 'Inquiry marked as unread.');
    }

    public function delete($id)
    {
        CarInquiry::findOrFail($id)->delete();
        session()->flash('message', 'Inquiry deleted successfully.');
    }

    public function render()
    {
        $query = CarInquiry::with(['car', 'user'])
            ->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('message', 'like', "%{$this->search}%");
            });

        if ($this->filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($this->filter === 'read') {
            $query->where('is_read', true);
        }

        return view('livewire.admin.car-inquiries', [
            'inquiries' => $query->latest()->paginate(10),
            'unreadCount' => CarInquiry::where('is_read', false)->count(),
        ]);
    }
}
