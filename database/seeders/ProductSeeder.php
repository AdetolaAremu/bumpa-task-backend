<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'title' => 'Wireless Mouse',
                'quantity' => 50,
                'description' => 'Ergonomic wireless mouse with adjustable DPI.',
                'sku' => 'WM-1001',
                'slug' => 'wireless-mouse',
                'price' => 29.99,
                'image_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Bluetooth Headphones',
                'quantity' => 30,
                'description' => 'Noise-cancelling over-ear headphones.',
                'sku' => 'BH-2002',
                'slug' => 'bluetooth-headphones',
                'price' => 59.99,
                'image_url' => 'https://images.unsplash.com/photo-1511367461989-f85a21fda167',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mechanical Keyboard',
                'quantity' => 20,
                'description' => 'RGB backlit mechanical keyboard for gaming.',
                'sku' => 'MK-3003',
                'slug' => 'mechanical-keyboard',
                'price' => 89.99,
                'image_url' => 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Smart Watch',
                'quantity' => 40,
                'description' => 'Fitness tracking smart watch with heart rate monitor.',
                'sku' => 'SW-4004',
                'slug' => 'smart-watch',
                'price' => 120.00,
                'image_url' => 'https://images.unsplash.com/photo-1516574187841-cb9cc2ca948b',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Portable Speaker',
                'quantity' => 25,
                'description' => 'Waterproof Bluetooth portable speaker.',
                'sku' => 'PS-5005',
                'slug' => 'portable-speaker',
                'price' => 45.50,
                'image_url' => 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'USB-C Charger',
                'quantity' => 60,
                'description' => 'Fast charging USB-C wall charger.',
                'sku' => 'UC-6006',
                'slug' => 'usb-c-charger',
                'price' => 19.99,
                'image_url' => 'https://images.unsplash.com/photo-1512446733611-9099a758e0c2',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Laptop Stand',
                'quantity' => 35,
                'description' => 'Adjustable aluminum laptop stand.',
                'sku' => 'LS-7007',
                'slug' => 'laptop-stand',
                'price' => 34.99,
                'image_url' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'External Hard Drive',
                'quantity' => 15,
                'description' => '2TB portable external hard drive.',
                'sku' => 'HD-8008',
                'slug' => 'external-hard-drive',
                'price' => 79.99,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Gaming Mouse Pad',
                'quantity' => 80,
                'description' => 'Large gaming mouse pad with non-slip base.',
                'sku' => 'MP-9009',
                'slug' => 'gaming-mouse-pad',
                'price' => 14.99,
                'image_url' => 'https://images.unsplash.com/photo-1518717758536-85ae29035b6d',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Action Camera',
                'quantity' => 10,
                'description' => '4K waterproof action camera.',
                'sku' => 'AC-1010',
                'slug' => 'action-camera',
                'price' => 150.00,
                'image_url' => 'https://images.unsplash.com/photo-1465101178521-c1a4c8a0f8f9',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        ProductCategory::insert([
            ['name' => 'Electronics', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accessories', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Audio', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wearables', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Storage', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gaming', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Office', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mobile', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cameras', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chargers', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $productIds = Product::pluck('id')->toArray();
        $categoryIds = ProductCategory::pluck('id')->toArray();

        $categoryProductData = [];
        for ($i = 0; $i < 10; $i++) {
            $categoryProductData[] = [
                'product_id' => $productIds[$i],
                'product_category_id' => $categoryIds[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        CategoryProduct::insert($categoryProductData);
    }
}
