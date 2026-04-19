<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        // Arabic category names with Picsum images
        $categories = [
            ['name' => 'الإلكترونيات',      'seed' => 1],
            ['name' => 'الملابس',            'seed' => 2],
            ['name' => 'الأثاث',             'seed' => 3],
            ['name' => 'الهواتف الذكية',     'seed' => 4],
            ['name' => 'الكمبيوتر والأجهزة', 'seed' => 5],
            ['name' => 'الساعات',            'seed' => 6],
            ['name' => 'الأحذية',            'seed' => 7],
            ['name' => 'الحقائب',            'seed' => 8],
            ['name' => 'الألعاب',            'seed' => 9],
            ['name' => 'العطور',             'seed' => 10],
        ];

        $picked = $this->faker->randomElement($categories);

        return [
            'name'      => $picked['name'],
            'slug'      => Str::slug($picked['name']) . '-' . uniqid(),
            'image'     => 'https://picsum.photos/seed/' . $picked['seed'] . '/640/480',
            'is_active' => true,
        ];
    }
}
