<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
        إتمام الطلب
    </h1>

    {{-- ─── رسالة الخطأ: السلة فارغة ─────────────────────────────── --}}
    @if(empty($cart_items))
        <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-xl p-4 mb-6 flex items-center gap-3">
            <span class="text-2xl">🛒</span>
            <p class="font-medium">سلة التسوق فارغة! <a href="/products" class="underline text-blue-600">تصفح المنتجات</a></p>
        </div>
    @endif

    <div class="grid grid-cols-12 gap-6">

        {{-- ════════════════════════════════════════════════════════
             العمود الأيسر: نموذج الطلب
        ════════════════════════════════════════════════════════ --}}
        <div class="md:col-span-12 lg:col-span-8 col-span-12">
            <div class="bg-white rounded-xl shadow p-6 dark:bg-slate-900">

                {{-- ─── عنوان الشحن ──────────────────────── --}}
                <h2 class="text-xl font-bold text-gray-700 dark:text-white mb-4 pb-2 border-b border-gray-200">
                    📍 عنوان الشحن
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    {{-- الاسم الأول --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1" for="first_name">
                            الاسم الأول <span class="text-red-500">*</span>
                        </label>
                        <input
                            wire:model="first_name"
                            id="first_name"
                            type="text"
                            placeholder="مثال: محمد"
                            class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                   @error('first_name') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                        />
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- الاسم الأخير --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1" for="last_name">
                            الاسم الأخير <span class="text-red-500">*</span>
                        </label>
                        <input
                            wire:model="last_name"
                            id="last_name"
                            type="text"
                            placeholder="مثال: أحمد"
                            class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                   @error('last_name') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                        />
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- رقم الهاتف --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1" for="phone">
                        رقم الهاتف (واتساب) <span class="text-red-500">*</span>
                    </label>
                    <input
                        wire:model="phone"
                        id="phone"
                        type="tel"
                        placeholder="مثال: 01012345678"
                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                               @error('phone') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                    />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- العنوان بالتفصيل --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1" for="street_address">
                        العنوان بالتفصيل <span class="text-red-500">*</span>
                    </label>
                    <input
                        wire:model="street_address"
                        id="street_address"
                        type="text"
                        placeholder="مثال: شارع التحرير، بجوار مسجد..."
                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                               @error('street_address') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                    />
                    @error('street_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- المحافظة والرمز البريدي --}}
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1" for="state">
                            المحافظة / المنطقة <span class="text-red-500">*</span>
                        </label>
                        <input
                            wire:model="state"
                            id="state"
                            type="text"
                            placeholder="مثال: القاهرة"
                            class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                   @error('state') border-red-500 bg-red-50 @else border-gray-300 @enderror"
                        />
                        @error('state')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1" for="zip_code">
                            الرمز البريدي <span class="text-gray-400 text-xs">(اختياري)</span>
                        </label>
                        <input
                            wire:model="zip_code"
                            id="zip_code"
                            type="text"
                            placeholder="مثال: 11511"
                            class="w-full rounded-lg border border-gray-300 py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                        />
                    </div>
                </div>

                {{-- ملاحظات إضافية --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1" for="notes">
                        ملاحظات إضافية <span class="text-gray-400 text-xs">(اختياري)</span>
                    </label>
                    <textarea
                        wire:model="notes"
                        id="notes"
                        rows="3"
                        placeholder="أي تعليمات خاصة للتوصيل أو الطلب..."
                        class="w-full rounded-lg border border-gray-300 py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none resize-none"
                    ></textarea>
                </div>

                {{-- ─── طريقة الدفع ──────────────────────── --}}
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">
                        💳 طريقة الدفع
                    </h3>

                    <div class="grid grid-cols-1 gap-3">
                        {{-- الدفع عند الاستلام --}}
                        <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-all
                                      border-green-500 bg-green-50 dark:bg-green-900/20">
                            <input
                                wire:model="payment_method"
                                type="radio"
                                value="cod"
                                class="w-4 h-4 text-green-600"
                                checked
                            />
                            <div>
                                <p class="font-bold text-gray-800 dark:text-white">💵 الدفع عند الاستلام (Cash on Delivery)</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    ستتلقى مكالمة أو رسالة واتساب لتأكيد طلبك قبل الشحن.
                                </p>
                            </div>
                        </label>
                    </div>

                    {{-- تنبيه مميز --}}
                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3 dark:bg-blue-900/20 dark:border-blue-700">
                        <span class="text-2xl mt-0.5">📞</span>
                        <div>
                            <p class="font-semibold text-blue-800 dark:text-blue-300">كيف تتم عملية التأكيد؟</p>
                            <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">
                                بعد تسجيل طلبك، سيتواصل معك فريقنا على رقم هاتفك خلال <strong>24 ساعة</strong>
                                عبر الهاتف أو واتساب لتأكيد الطلب وترتيب التوصيل.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════
             العمود الأيمن: ملخص الطلب
        ════════════════════════════════════════════════════════ --}}
        <div class="md:col-span-12 lg:col-span-4 col-span-12">

            {{-- ─── ملخص الأسعار ─────────────────────────── --}}
            <div class="bg-white rounded-xl shadow p-5 dark:bg-slate-900">
                <h2 class="text-xl font-bold text-gray-700 dark:text-white mb-4 pb-2 border-b border-gray-200">
                    🧾 ملخص الطلب
                </h2>

                <div class="flex justify-between mb-2 text-gray-600 dark:text-gray-300">
                    <span>المجموع الفرعي</span>
                    <span>{{ number_format($grand_total, 2) }} ج.م</span>
                </div>
                <div class="flex justify-between mb-2 text-gray-600 dark:text-gray-300">
                    <span>الضرائب</span>
                    <span>0.00 ج.م</span>
                </div>
                <div class="flex justify-between mb-2 text-gray-600 dark:text-gray-300">
                    <span>تكلفة الشحن</span>
                    <span class="text-green-600 font-semibold">مجاني</span>
                </div>
                <hr class="my-3 border-gray-200">
                <div class="flex justify-between font-bold text-lg text-gray-800 dark:text-white">
                    <span>الإجمالي 💰</span>
                    <span class="text-green-600">{{ number_format($grand_total, 2) }} ج.م</span>
                </div>
            </div>

            {{-- ─── زر الطلب ────────────────────────────────── --}}
            <button
                wire:click="placeOrder"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-60 cursor-not-allowed"
                id="place-order-btn"
                class="bg-green-500 mt-4 w-full p-4 rounded-xl text-lg font-bold text-white
                       hover:bg-green-600 active:scale-95 transition-all duration-200 flex items-center justify-center gap-2"
            >
                <span wire:loading.remove wire:target="placeOrder">
                    ✅ تأكيد وإرسال الطلب
                </span>
                <span wire:loading wire:target="placeOrder" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    جاري تسجيل الطلب...
                </span>
            </button>

            {{-- ─── محتويات السلة ────────────────────────── --}}
            <div class="bg-white mt-4 rounded-xl shadow p-5 dark:bg-slate-900">
                <h2 class="text-xl font-bold text-gray-700 dark:text-white mb-4 pb-2 border-b border-gray-200">
                    🛍️ منتجات الطلب
                </h2>

                @if(!empty($cart_items))
                    <ul class="divide-y divide-gray-100 dark:divide-gray-700" role="list">
                        @foreach($cart_items as $item)
                            <li class="py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0">
                                        @if(!empty($item['image']))
                                            <img
                                                src="{{ asset('storage/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}"
                                                class="w-12 h-12 rounded-lg object-cover border border-gray-200"
                                                onerror="this.src='https://via.placeholder.com/48'"
                                            />
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400 text-xl">📦</div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $item['name'] }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            الكمية: {{ $item['quantity'] }} × {{ number_format($item['unit_amount'], 2) }} ج.م
                                        </p>
                                    </div>
                                    <div class="font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ number_format($item['total_amount'], 2) }} ج.م
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400 text-center py-4">لا توجد منتجات في السلة</p>
                @endif
            </div>

        </div>
    </div>
</div>