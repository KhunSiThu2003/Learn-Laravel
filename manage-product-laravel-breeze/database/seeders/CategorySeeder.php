<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Mobile Phones',
            'Laptops',
            'Accessories',
            'Fashion',
            'Shoes',
            'Home Appliances',
            'Beauty',
            'Sports',
            'Books',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name'        => $category,
                'description' => $category . ' related products category',
                'status'      => true,
            ]);
        }
    }
}
