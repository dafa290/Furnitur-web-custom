<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Amara Lounge Chair', 'price' => 4850000, 'category' => 'Kursi', 'color' => 'Natural', 'material' => 'Kayu', 'stock' => 15, 'img' => 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=600&h=450&fit=crop'],
            ['name' => 'Nara Coffee Table', 'price' => 3250000, 'category' => 'Meja', 'color' => 'Walnut', 'material' => 'Kayu', 'stock' => 23, 'img' => 'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?w=600&h=450&fit=crop'],
            ['name' => 'Orion Wardrobe', 'price' => 12450000, 'category' => 'Lemari', 'color' => 'Natural', 'material' => 'Kayu', 'stock' => 8, 'img' => 'https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=600&h=450&fit=crop'],
            ['name' => 'Serene Bed Frame', 'price' => 9850000, 'category' => 'Tempat Tidur', 'color' => 'Beige', 'material' => 'Kayu', 'stock' => 12, 'img' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=600&h=450&fit=crop'],
            ['name' => 'Lumina Sofa', 'price' => 14300000, 'category' => 'Sofa', 'color' => 'Olive', 'material' => 'Fabric', 'stock' => 6, 'img' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&h=450&fit=crop'],
            ['name' => 'Strada Dining Chair', 'price' => 2950000, 'category' => 'Kursi', 'color' => 'Charcoal', 'material' => 'Metal', 'stock' => 35, 'img' => 'https://images.unsplash.com/photo-1592078615290-033ee584e267?w=600&h=450&fit=crop'],
            ['name' => 'Solace Desk', 'price' => 4350000, 'category' => 'Meja', 'color' => 'Walnut', 'material' => 'Kayu', 'stock' => 18, 'img' => 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?w=600&h=450&fit=crop'],
            ['name' => 'Cielo Sideboard', 'price' => 6850000, 'category' => 'Lemari', 'color' => 'Natural', 'material' => 'Kayu', 'stock' => 10, 'img' => 'https://images.unsplash.com/photo-1615873968403-89e0686299f4?w=600&h=450&fit=crop'],
            ['name' => 'Breeze Daybed', 'price' => 11900000, 'category' => 'Tempat Tidur', 'color' => 'Beige', 'material' => 'Fabric', 'stock' => 5, 'img' => 'https://images.unsplash.com/photo-1505693314120-0d2d56d1f131?w=600&h=450&fit=crop'],
            ['name' => 'Milo Armchair', 'price' => 5650000, 'category' => 'Kursi', 'color' => 'Olive', 'material' => 'Fabric', 'stock' => 14, 'img' => 'https://images.unsplash.com/photo-1580480055273-228ff5388ef8?w=600&h=450&fit=crop'],
            ['name' => 'Axis Modular Sofa', 'price' => 18900000, 'category' => 'Sofa', 'color' => 'Charcoal', 'material' => 'Fabric', 'stock' => 4, 'img' => 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?w=600&h=450&fit=crop'],
            ['name' => 'Terra Console', 'price' => 3590000, 'category' => 'Meja', 'color' => 'Walnut', 'material' => 'Metal', 'stock' => 22, 'img' => 'https://images.unsplash.com/photo-1616486338812-3aadae4b4ace?w=600&h=450&fit=crop'],
            ['name' => 'Flora Bookshelf', 'price' => 4950000, 'category' => 'Lemari', 'color' => 'Natural', 'material' => 'Kayu', 'stock' => 16, 'img' => 'https://images.unsplash.com/photo-1594620302200-9a762244a3bc?w=600&h=450&fit=crop'],
            ['name' => 'Velvet Ottoman', 'price' => 2250000, 'category' => 'Kursi', 'color' => 'Olive', 'material' => 'Fabric', 'stock' => 28, 'img' => 'https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=600&h=450&fit=crop'],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, ['rating' => 4.5, 'customizable' => false, 'base_price' => $product['price']]));
        }
    }
}
