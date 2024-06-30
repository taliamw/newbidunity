<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('new_products')->insert([
                'name' => 'Product ' . $i,
                'description' => 'This is a description for Product ' . $i,
                'price' => rand(10, 100),
                'image' => 'images/products/company.jpg', // Use a real image path
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
