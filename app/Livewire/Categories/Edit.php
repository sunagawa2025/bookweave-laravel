<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;

class Edit extends Component
{
    public Category $category;

    public $category_name;

    public function mount(Category $category){
        $this->category = $category;
        $this->category_name = $category->category_name;
    }

    public function update(){
        $validated = $this->validate([
            'category_name' => 'required|string|max:255',
        ]);
        $this->category->update($validated);
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.edit');
    }
}
