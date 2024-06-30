<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $images = [
            'images/products/company.jpg',
            'images\products\land.jpg',
            'images/products/product3.jpg',
            // Add paths to your images
        ];

        foreach ($images as $image) {
            Product::create([
                'name' => 'Product ' . rand(1, 100),
                'description' => 'This is a description for Product ' . rand(1, 100),
                'price' => rand(10, 100),
                'image' => $image,
            ]);
        }
    }
}
