<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;

class Create extends Component
{
    public $category_name;

    public function save(){
        $validated = $this->validate([
            'category_name' => 'required|string|max:255'
        ]);
        Category::create($validated);
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.create');
    }
}
