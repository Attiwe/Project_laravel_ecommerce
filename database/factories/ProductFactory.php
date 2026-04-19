<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        // Arabic product names
        $productNames = [
            'هاتف ذكي سامسونج',      'لابتوب ديل برو',          'سماعات لاسلكية',
            'ساعة ذكية',               'شاشة 4K',                 'كاميرا احترافية',
            'لوحة مفاتيح ميكانيكية',  'ماوس لاسلكي',             'حقيبة ظهر جلدية',
            'حذاء رياضي',              'قميص قطني',               'عطر فاخر',
            'نظارة شمسية',             'مكيف هواء',               'ثلاجة ذكية',
            'غسالة أوتوماتيك',        'مكنسة كهربائية',          'مروحة حائطية',
            'طاولة خشبية',             'كرسي مكتب',
        ];

        // Arabic product descriptions
        $descriptions = [
            'منتج عالي الجودة مصنوع من أفضل المواد مع ضمان سنة كاملة.',
            'تصميم أنيق وعصري يناسب جميع الأذواق مع مواصفات تقنية متطورة.',
            'يتميز بأداء استثنائي وعمر بطارية طويل ومتانة عالية.',
            'مثالي للاستخدام اليومي، يجمع بين الشكل الجميل والوظيفة العملية.',
            'منتج فاخر بسعر مناسب، يأتي في عبوة أنيقة مثالية للهدايا.',
            'يوفر تجربة مستخدم لا مثيل لها مع خصائص حصرية ومبتكرة.',
        ];

        $name = $this->faker->randomElement($productNames);
        $description = $this->faker->randomElement($descriptions);
        $seed = rand(30, 200);

        return [
            'category_id'   => Category::inRandomOrder()->first()->id ?? 1,
            'brand_id'      => Brand::inRandomOrder()->first()->id ?? 1,
            'name'          => $name,
            'slug'          => Str::slug($name) . '-' . uniqid(),
            // Three direct internet images via Picsum (no storage needed)
            'images'        => [
                'https://picsum.photos/seed/' . $seed . '/640/480',
                'https://picsum.photos/seed/' . ($seed + 1) . '/640/480',
                'https://picsum.photos/seed/' . ($seed + 2) . '/640/480',
            ],
            'descriptian'   => $description,
            'price'         => $this->faker->randomFloat(2, 50, 5000),
            'is_active'     => true,
            'is_featured'   => $this->faker->boolean,
            'in_stock'      => $this->faker->numberBetween(1, 200),
            'on_sale'       => $this->faker->boolean,
        ];
    }
}
