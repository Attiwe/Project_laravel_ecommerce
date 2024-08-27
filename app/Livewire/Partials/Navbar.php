<?php

namespace App\Livewire\Partials;
use Livewire\Attributes\On;

use App\Helpers\CartManagement;
use Livewire\Component;

class Navbar extends Component
{

    //Not
    public $total_count = 0;
    public function mount(){
      $this ->total_count = count(CartManagement::getCartItemsFromCookie());
    }

    #[on('update-cart-count')]
    public function updateCartCount($total_count){
        $this->total_count = $total_count ;
    }
    
    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
