<?php

namespace App\Livewire\Admin;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRating = '';
    public $viewingReview = null;

    public function view($id)
    {
        $this->viewingReview = Review::with(['reviewer', 'seller', 'car.maker', 'car.model'])->findOrFail($id);
    }

    public function closeView()
    {
        $this->viewingReview = null;
    }


    public function delete($id)
    {
        Review::findOrFail($id)->delete();
        session()->flash('message', 'Review deleted successfully.');
    }

    public function render()
    {
        $query = Review::with(['reviewer', 'seller', 'car'])
            ->where(function($q) {
                $q->whereHas('reviewer', fn($query) =>
                    $query->where('name', 'like', "%{$this->search}%"))
                  ->orWhereHas('seller', fn($query) =>
                    $query->where('name', 'like', "%{$this->search}%"))
                  ->orWhere('comment', 'like', "%{$this->search}%");
            });

        if ($this->filterRating) {
            $query->where('rating', $this->filterRating);
        }

        return view('livewire.admin.reviews', [
            'reviews' => $query->latest()->paginate(10),
            'averageRating' => Review::avg('rating'),
            'totalReviews' => Review::count(),
        ]);
    }
}
