<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Title;
 

#[Title('Home Page - Shopping')]
class HomePage extends Component
{
    public function render()
    {
        $brand   = Brand::where('is_active', 1)->get();
        $Category = Category::where('is_active',1)->get();
        // dd($brand);
        return view('livewire.home-page',[
        'brands'   => $brand ,
        'Category' => $Category,
        
        
        ] );
    }
}
