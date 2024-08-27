<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
    <div class="flex flex-col md:flex-row gap-4">
      <div class="md:w-3/4">
        <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
        
        
        @forelse($cart_items as $item)

        <table class="w-full">
            <thead>
              <tr>
                <th class="text-left font-semibold">Product</th>
                <th class="text-left font-semibold">Price</th>
                <th class="text-left font-semibold">Quantity</th>
                <th class="text-left font-semibold">Total</th>
                <th class="text-left font-semibold">Remove</th>
              </tr>
            </thead>
            <tbody>
              <tr wire:key="{{ $item['product_id'] }}">
                <td class="py-4">
                  <div class="flex items-center">
                    <img class="h-16 w-16 mr-4" src=" {{ url('storage', $item['image']) }}" alt="Product image">
                    <span class="font-semibold">Product name</span>
                  </div>
                </td>
                <td class="py-4">{{Number::currency($item['unit_amount'],'EGP')}} </td>
                <td class="py-4">
                  <div class="flex items-center">
                    <button class="border rounded-md py-2 px-4 mr-2">-</button>
                    <span class="text-center w-8">{{$item['quantity']}}</span>
                    <button class="border rounded-md py-2 px-4 ml-2">+</button>
                  </div>
                </td>
                <td class="py-4">{{Number::currency($item['total_amount'],'EGP')}}</td>
                <td><button wire:click="removeItem({{$item['product_id']}})" class="bg-slate-300 border-2 border-slate-400 rounded-lg px-3 py-1 hover:bg-red-500 hover:text-white hover:border-red-700">
                  
                Remove</button></td>
              </tr>
              <!-- More product rows -->
            </tbody>
          </table>
       


    @empty
    @endforelse
    
    
       
       
        </div>
      </div>
      <div class="md:w-1/4">
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-lg font-semibold mb-4">Summary</h2>
          <div class="flex justify-between mb-2">
            <span>Subtotal</span>
            <span> {{Number::currency($item['total_amount'],'EGP')}}</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>Taxes</span>
            <span>{{Number::currency( 0 ,'EGP')}}</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>Shipping</span>
            <span>{{Number::currency( 0,'EGP')}}</span>
          </div>
          <hr class="my-2">
          <div class="flex justify-between mb-2">
            <span class="font-semibold">Grand Total</span>
            <span class="font-semibold">{{Number::currency($item['total_amount'] ,'EGP')}}</span>
          </div>
          <button class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</button>
        </div>
      </div>
    </div>
  </div>
</div>