<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create dummy products
        $products = [
            [
                'name' => 'Product 1',
                'description' => 'Description for Product 1',
                'price' => 10.99,
                'image_url' => 'img\company.jpg',
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for Product 2',
                'price' => 15.99,
                'image_url' =>img\land.jpg, // No image available
            ],
            // [
            //     'name' => 'Product 3',
            //     'description' => 'Description for Product 3',
            //     'price' => 20.99,
            //     'image_url' => 'https://via.placeholder.com/150',
            // ],
            // // Add more products as needed
        ];

        // Insert products into the database
        foreach ($products as $productData) {
            $product = new Product();
            $product->name = $productData['name'];
            $product->description = $productData['description'];
            $product->price = $productData['price'];
            $product->image_url = $productData['image_url'];
            $product->save();
        }
    }
}
