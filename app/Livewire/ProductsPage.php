<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand; 
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
 




#[Title('Products Page-Shopping')]
class ProductsPage extends Component
{
    
    use WithPagination;
    use LivewireAlert;
    #[Url]

    public $selected_catagres = [];

    #[Url]
    public $select_brand = [];
    
    
    #[Url]
    public $Selected_featured = [];
    
    #[Url]
    public $selected_sale = [];


    #[Url]
    public $price_rang = 300000;

//    add product to cart   /////////////// Not 
    public function addToCart($product_id){
        // dd($product_id);
        $total_count = CartManagement::addItemToCart($product_id );
        $this->dispatch('update-cart-count', total_count:$total_count)->to(Navbar::class);
  
        $this->alert('success', 'Product added to the cart succcessfully!  ', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
            ]);
    }


 


    public function render()
    {


        $productsQuery = Product::query()->where('is_active', 1);


        if (!empty($this->selected_catagres)) {
            $productsQuery = Product::whereIn('category_id', $this->selected_catagres);
        }
        if (!empty($this->select_brand)) {
            $productsQuery = Product::whereIn('category_id', $this->select_brand);
        }
      
        if ($this->Selected_featured) {
            $productsQuery = Product::whereIn('is_featured', $this->Selected_featured);
        }
      
        if ($this->selected_sale) {
            $productsQuery = Product::whereIn('on_sale', $this->selected_sale);
        }

        $product = $productsQuery->paginate(6);

        $brand = Brand::query()->where('is_active', 1)->get(['id', 'name', 'slug']);

        $Categorys = Category::where('is_active', 1)->get(['id', 'name', 'slug']);

    if($this->price_rang){
        $productsQuery->whereBetween('price',[0,$this->price_rang]);
    }


        return view(
            'livewire.products-page',

            [
                'products' => $product,

                'category' => $Categorys,

                'brands' => $brand,
            ]
        );
    }
}
