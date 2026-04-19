<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        // Arabic brand names with Picsum images
        $brands = [
            ['name' => 'سامسونج',   'seed' => 20],
            ['name' => 'آبل',        'seed' => 21],
            ['name' => 'هواوي',      'seed' => 22],
            ['name' => 'شاومي',      'seed' => 23],
            ['name' => 'سوني',       'seed' => 24],
            ['name' => 'نوكيا',      'seed' => 25],
            ['name' => 'ديل',        'seed' => 26],
            ['name' => 'إتش بي',     'seed' => 27],
            ['name' => 'لينوفو',     'seed' => 28],
            ['name' => 'أوبو',       'seed' => 29],
        ];

        $picked = $this->faker->randomElement($brands);

        return [
            'name'      => $picked['name'],
            'slug'      => Str::slug($picked['name']) . '-' . uniqid(),
            'image'     => 'https://picsum.photos/seed/' . $picked['seed'] . '/640/480',
            'is_active' => true,
        ];
    }
}
