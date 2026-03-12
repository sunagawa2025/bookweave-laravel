<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Config;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $dbConfig = Config::first();
        $limit = $dbConfig->pagination_count ?? 10;
        $categories = Category::paginate($limit);
        
        return view('livewire.categories.index', compact('categories'));
        
    }
}
