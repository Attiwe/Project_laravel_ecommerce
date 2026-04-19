<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Checkout - إتمام الطلب')]
class CheckoutPage extends Component
{
    // ─── Address fields ───────────────────────────────────────────
    public $first_name    = '';
    public $last_name     = '';
    public $phone         = '';
    public $street_address = '';
    public $state         = '';
    public $zip_code      = '';

    // ─── Order fields ─────────────────────────────────────────────
    public $payment_method = 'cod';   // default: Cash on Delivery
    public $notes          = '';

    // ─── Cart data ────────────────────────────────────────────────
    public $cart_items = [];
    public $grand_total = 0;

    public function mount()
    {
        $this->cart_items  = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        // إذا كانت السلة فارغة، ارجع للسلة
        if (empty($this->cart_items)) {
            return $this->redirect('/cart');  // ✔ return ضروري
        }
    }

    protected function rules(): array
    {
        return [
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'state'          => 'required|string|max:100',
            'zip_code'       => 'nullable|string|max:20',
            'notes'          => 'nullable|string|max:500',
        ];
    }

    protected function messages(): array
    {
        return [
            'first_name.required'     => 'الاسم الأول مطلوب.',
            'last_name.required'      => 'الاسم الأخير مطلوب.',
            'phone.required'          => 'رقم الهاتف مطلوب.',
            'street_address.required' => 'العنوان مطلوب.',
            'state.required'          => 'المحافظة / المنطقة مطلوبة.',
        ];
    }

    public function placeOrder()
    {
        // 1. التحقق من صحة البيانات
        $this->validate();

        // 2. التحقق من أن السلة ليست فارغة
        $cart_items = CartManagement::getCartItemsFromCookie();
        if (empty($cart_items)) {
            return $this->redirect('/cart');
        }

        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        // 3. حفظ الطلب داخل Transaction لضمان سلامة البيانات
        $order = DB::transaction(function () use ($cart_items, $grand_total) {

            // إنشاء الطلب
            $order = Order::create([
                'user_id'         => auth()->id(),
                'grand_total'     => $grand_total,
                'payment_method'  => 'cod',
                'payment_status'  => 'pending',
                'status'          => 'new',
                'currency'        => 'EGP',
                'shipping_amount' => 0,
                'shiping_method'  => 'none',
                'notes'           => $this->notes,
            ]);

            // إنشاء عناصر الطلب
            foreach ($cart_items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item['product_id'],
                    'quantity'     => $item['quantity'],
                    'unit_amount'  => $item['unit_amount'],
                    'total_amount' => $item['total_amount'],
                ]);
            }

            // إنشاء عنوان الشحن
            Address::create([
                'order_id'       => $order->id,
                'first_name'     => $this->first_name,
                'last_name'      => $this->last_name,
                'phone'          => $this->phone,
                'street_address' => $this->street_address,
                'state'          => $this->state,
                'Zip_code'       => $this->zip_code,
            ]);

            return $order;
        });

        // 4. مسح السلة بعد إتمام الطلب
        CartManagement::clearCartItems();

        // تحديث عداد السلة في الـ Navbar
        $this->dispatch('update-cart-count', total_count: 0)->to(Navbar::class);

        // 5. تخزين بيانات التأكيد في الـ session
        session()->put('order_success', [
            'order_id' => $order->id,
            'phone'    => $this->phone,
        ]);

        // 6. التوجيه لصفحة طلباتي
        return redirect('/my-orders');
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
