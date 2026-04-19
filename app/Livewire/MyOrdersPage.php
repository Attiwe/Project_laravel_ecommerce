<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('طلباتي')]
class MyOrdersPage extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->latest()
                       ->get();

        return view('livewire.my-orders-page', compact('orders'));
    }
}
