<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;

class ContactMessages extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';

    public function markAsRead($id)
    {
        ContactMessage::findOrFail($id)->update(['is_read' => true]);
        session()->flash('message', 'Message marked as read.');
    }

    public function markAsUnread($id)
    {
        ContactMessage::findOrFail($id)->update(['is_read' => false]);
        session()->flash('message', 'Message marked as unread.');
    }

    public function delete($id)
    {
        ContactMessage::findOrFail($id)->delete();
        session()->flash('message', 'Message deleted successfully.');
    }

    public function render()
    {
        $query = ContactMessage::query()
            ->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('subject', 'like', "%{$this->search}%")
                  ->orWhere('message', 'like', "%{$this->search}%");
            });

        if ($this->filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($this->filter === 'read') {
            $query->where('is_read', true);
        }

        return view('livewire.admin.contact-messages', [
            'messages' => $query->latest()->paginate(10),
            'unreadCount' => ContactMessage::where('is_read', false)->count(),
        ]);
    }
}
