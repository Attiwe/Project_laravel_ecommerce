<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">

    <h1 class="text-3xl font-bold text-slate-700 dark:text-white mb-6">📦 طلباتي</h1>

    {{-- ══════════════════════════════════════════════════════════════
         رسالة تأكيد بعد تسجيل الطلب (تظهر مرة واحدة فقط)
    ══════════════════════════════════════════════════════════════ --}}
    @if(session()->has('order_success'))
        @php
            $orderSuccess = session()->pull('order_success');
        @endphp
        <div class="bg-green-50 border border-green-300 rounded-xl p-5 mb-6 flex items-start gap-4
                    dark:bg-green-900/20 dark:border-green-600 animate-pulse"
             style="animation-iteration-count: 3;">
            <span class="text-3xl">🎉</span>
            <div>
                <p class="text-lg font-bold text-green-800 dark:text-green-300">
                    تم استلام طلبك بنجاح!
                </p>
                <p class="text-sm text-green-700 dark:text-green-400 mt-1">
                    📦 طلبك رقم <strong>#{{ $orderSuccess['order_id'] }}</strong> قيد المراجعة —
                    سنتواصل معك على الرقم <strong>{{ $orderSuccess['phone'] }}</strong>
                    خلال <strong>24 ساعة</strong> عبر الهاتف أو واتساب لتأكيد الطلب وترتيب التوصيل.
                </p>
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         جدول الطلبات
    ══════════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col bg-white p-5 rounded-xl mt-2 shadow-lg dark:bg-slate-900">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">

                    @if($orders->isEmpty())
                        <div class="text-center py-16 text-gray-400">
                            <p class="text-5xl mb-4">🛒</p>
                            <p class="text-lg font-medium">لا توجد طلبات بعد.</p>
                            <a href="/products"
                               class="mt-4 inline-block bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                                ابدأ التسوق الآن
                            </a>
                        </div>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                <tr>
                                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"># الطلب</th>
                                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">التاريخ</th>
                                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">حالة الطلب</th>
                                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">حالة الدفع</th>
                                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">الإجمالي</th>
                                    <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">التفاصيل</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800 transition">

                                        {{-- رقم الطلب --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800 dark:text-gray-200">
                                            #{{ $order->id }}
                                        </td>

                                        {{-- التاريخ --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                            {{ $order->created_at->format('d-m-Y') }}
                                        </td>

                                        {{-- حالة الطلب --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $statusMap = [
                                                    'new'        => ['label' => 'جديد',         'class' => 'bg-blue-100 text-blue-800'],
                                                    'processing' => ['label' => 'قيد التأكيد',   'class' => 'bg-orange-100 text-orange-800'],
                                                    'shipped'    => ['label' => 'تم الشحن',      'class' => 'bg-purple-100 text-purple-800'],
                                                    'deliverd'   => ['label' => 'تم التسليم',    'class' => 'bg-green-100 text-green-800'],
                                                    'canceled'   => ['label' => 'ملغي',          'class' => 'bg-red-100 text-red-800'],
                                                ];
                                                $status = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-100 text-gray-800'];
                                            @endphp
                                            <span class="py-1 px-3 rounded-full text-xs font-semibold {{ $status['class'] }}">
                                                {{ $status['label'] }}
                                            </span>
                                        </td>

                                        {{-- حالة الدفع --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($order->payment_status === 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-semibold">
                                                    ⏳ في انتظار التأكيد
                                                </span>
                                            @elseif($order->payment_status === 'paid')
                                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-semibold">
                                                    ✅ مدفوع
                                                </span>
                                            @else
                                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-semibold">
                                                    ❌ فشل الدفع
                                                </span>
                                            @endif
                                        </td>

                                        {{-- الإجمالي --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800 dark:text-white">
                                            {{ number_format($order->grand_total, 2) }} ج.م
                                        </td>

                                        {{-- رابط التفاصيل --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm">
                                            <a href="/my-orders/{{ $order->id }}"
                                               class="bg-slate-600 text-white py-2 px-4 rounded-lg
                                                      hover:bg-slate-500 transition text-xs font-medium">
                                                عرض التفاصيل
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>