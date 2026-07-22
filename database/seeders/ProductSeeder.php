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
            ['name' => 'Cielo Table', 'price' => 6850000, 'category' => 'Meja', 'color' => 'Natural', 'material' => 'Kayu', 'stock' => 10, 'img' => 'https://images.unsplash.com/photo-1538688525198-9b88f6f53126?w=600&h=450&fit=crop'],
            ['name' => 'Breeze Daybed', 'price' => 11900000, 'category' => 'Tempat Tidur', 'color' => 'Beige', 'material' => 'Fabric', 'stock' => 5, 'img' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=600&h=450&fit=crop'],
            ['name' => 'Milo Armchair', 'price' => 5650000, 'category' => 'Kursi', 'color' => 'Olive', 'material' => 'Fabric', 'stock' => 14, 'img' => 'https://images.unsplash.com/photo-1580480055273-228ff5388ef8?w=600&h=450&fit=crop'],
            ['name' => 'Axis Modular Sofa', 'price' => 18900000, 'category' => 'Sofa', 'color' => 'Charcoal', 'material' => 'Fabric', 'stock' => 4, 'img' => 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?w=600&h=450&fit=crop'],
            ['name' => 'Terra Console', 'price' => 3590000, 'category' => 'Meja', 'color' => 'Walnut', 'material' => 'Metal', 'stock' => 22, 'img' => 'https://images.unsplash.com/photo-1618219908412-a29a1bb7b86e?w=600&h=450&fit=crop'],
            ['name' => 'Flora Chair', 'price' => 4950000, 'category' => 'Kursi', 'color' => 'Natural', 'material' => 'Kayu', 'stock' => 16, 'img' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&h=450&fit=crop'],
            ['name' => 'Velvet Ottoman', 'price' => 2250000, 'category' => 'Kursi', 'color' => 'Olive', 'material' => 'Fabric', 'stock' => 28, 'img' => 'https://images.unsplash.com/photo-1581539250439-c96689b516dd?w=600&h=450&fit=crop'],
            
            // New products
            ['name' => 'Elegant Dining Table', 'price' => 5500000, 'category' => 'Meja', 'color' => 'Walnut', 'material' => 'Kayu', 'stock' => 10, 'img' => '/assets/images/products/produk-16.jpg', 'description' => 'Meja makan elegan dengan sentuhan kayu walnut berkualitas tinggi. Cocok untuk ruang makan keluarga yang hangat.'],
            ['name' => 'Lounge Relax Chair', 'price' => 2800000, 'category' => 'Kursi', 'color' => 'Grey', 'material' => 'Fabric', 'stock' => 15, 'img' => '/assets/images/products/produk-17.jpg', 'description' => 'Kursi santai dengan dudukan busa tebal yang nyaman. Desain modern minimalis untuk menemani waktu istirahat Anda.'],
            ['name' => 'Modern Minimalist Table', 'price' => 8900000, 'category' => 'Meja', 'color' => 'White', 'material' => 'Kayu', 'stock' => 5, 'img' => '/assets/images/products/produk-18.jpg', 'description' => 'Meja desain minimalis perpaduan warna putih dan kayu natural.'],
            ['name' => 'Royal King Bed', 'price' => 12500000, 'category' => 'Tempat Tidur', 'color' => 'Beige', 'material' => 'Kayu & Fabric', 'stock' => 4, 'img' => '/assets/images/products/produk-19.jpg', 'description' => 'Rangka tempat tidur ukuran King dengan sandaran empuk yang mewah. Menghadirkan nuansa hotel bintang lima di kamar Anda.'],
            ['name' => 'Cozy Corner Wooden Table', 'price' => 15500000, 'category' => 'Meja', 'color' => 'Charcoal', 'material' => 'Kayu', 'stock' => 3, 'img' => '/assets/images/products/produk-20.jpg', 'description' => 'Meja sudut kayu yang sangat kokoh dan fungsional. Cocok untuk ruang keluarga.'],
            ['name' => 'Vintage Wooden Sofa', 'price' => 4200000, 'category' => 'Sofa', 'color' => 'Natural', 'material' => 'Kayu', 'stock' => 8, 'img' => '/assets/images/products/produk-21.jpg', 'description' => 'Sofa berbahan kayu dengan gaya *vintage* klasik. Dilengkapi bantal dudukan empuk.'],
            ['name' => 'Ergonomic Office Chair', 'price' => 1950000, 'category' => 'Kursi', 'color' => 'Black', 'material' => 'Mesh & Metal', 'stock' => 25, 'img' => '/assets/images/products/produk-22.jpg', 'description' => 'Kursi kantor ergonomis yang menjaga postur punggung tetap ideal. Terdapat fitur pengaturan ketinggian dan kemiringan otomatis.'],
            ['name' => 'Glass Display Table', 'price' => 6700000, 'category' => 'Meja', 'color' => 'Gold', 'material' => 'Kaca & Metal', 'stock' => 7, 'img' => '/assets/images/products/produk-23.jpg', 'description' => 'Meja elegan dengan permukaan kaca dan rangka logam emas.'],
            ['name' => 'Scandinavian Queen Bed', 'price' => 7200000, 'category' => 'Tempat Tidur', 'color' => 'Natural', 'material' => 'Kayu', 'stock' => 11, 'img' => '/assets/images/products/produk-24.jpg', 'description' => 'Tempat tidur gaya Skandinavia yang simpel dan kokoh. Dibuat dari kayu oak asli yang tahan lama.'],
            ['name' => 'Plush Wooden Table', 'price' => 9800000, 'category' => 'Meja', 'color' => 'Navy Blue', 'material' => 'Kayu', 'stock' => 6, 'img' => '/assets/images/products/produk-25.jpg', 'description' => 'Meja kayu berkualitas tinggi dengan ukiran aksen yang elegan pada ruang tamu Anda.'],
            
            // 9 Additional new products
            ['name' => 'Classic Teak Bed', 'price' => 1400000, 'category' => 'Tempat Tidur', 'color' => 'Brown', 'material' => 'Kayu Jati', 'stock' => 20, 'img' => '/assets/images/products/produk-26.jpg', 'description' => 'Ranjang klasik yang terbuat dari kayu jati asli. Sangat kokoh, tahan lama, dan memiliki serat kayu yang indah.'],
            ['name' => 'Luxe Marble Coffee Table', 'price' => 4500000, 'category' => 'Meja', 'color' => 'White Marble', 'material' => 'Marble & Metal', 'stock' => 8, 'img' => '/assets/images/products/produk-27.jpg', 'description' => 'Meja tamu elegan dengan permukaan marmer asli dan kaki besi berwarna emas. Cocok untuk ruang tamu bergaya modern mewah.'],
            ['name' => 'Minimalist Sliding Sofa', 'price' => 7600000, 'category' => 'Sofa', 'color' => 'White & Wood', 'material' => 'Kayu', 'stock' => 6, 'img' => '/assets/images/products/produk-28.jpg', 'description' => 'Sofa dengan rangka kayu yang menghemat ruang. Desain minimalis perpaduan warna putih dan kayu natural.'],
            ['name' => 'Comfy Cloud Sofa 3-Seater', 'price' => 11200000, 'category' => 'Sofa', 'color' => 'Light Grey', 'material' => 'Fabric', 'stock' => 5, 'img' => '/assets/images/products/produk-29.jpg', 'description' => 'Sofa 3 dudukan super empuk bagai awan. Menggunakan busa kepadatan tinggi yang tidak mudah kempes meskipun diduduki berjam-jam.'],
            ['name' => 'Industrial Study Bed', 'price' => 3100000, 'category' => 'Tempat Tidur', 'color' => 'Rustic Brown', 'material' => 'Kayu & Besi', 'stock' => 14, 'img' => '/assets/images/products/produk-30.jpg', 'description' => 'Tempat tidur bergaya industrial. Memiliki rangka besi hitam tebal dan kayu bernuansa *rustic*.'],
            ['name' => 'Aesthetic Rattan Bed', 'price' => 2100000, 'category' => 'Tempat Tidur', 'color' => 'Natural Rattan', 'material' => 'Rotan & Kayu', 'stock' => 12, 'img' => '/assets/images/products/produk-31.jpg', 'description' => 'Tempat tidur dengan aksen rotan asli yang estetik. Memberikan kesan *tropical* dan santai pada hunian Anda.'],
            ['name' => 'Premium Spring Bed Set', 'price' => 14500000, 'category' => 'Tempat Tidur', 'color' => 'Grey', 'material' => 'Fabric & Spring', 'stock' => 4, 'img' => '/assets/images/products/produk-32.jpg', 'description' => 'Satu set tempat tidur dan kasur *spring bed* premium. Dirancang khusus untuk menopang tulang belakang Anda dengan sempurna.'],
            ['name' => 'Multipurpose Storage Cabinet', 'price' => 5200000, 'category' => 'Lemari', 'color' => 'Oak', 'material' => 'Kayu', 'stock' => 9, 'img' => '/assets/images/products/produk-33.jpg', 'description' => 'Kabinet penyimpanan serbaguna dengan banyak laci dan rak tertutup. Dapat digunakan di dapur, ruang keluarga, atau kamar tidur.'],
            ['name' => 'Contemporary Accent Cabinet', 'price' => 3800000, 'category' => 'Lemari', 'color' => 'Mustard Yellow', 'material' => 'Kayu', 'stock' => 7, 'img' => '/assets/images/products/produk-34.jpg', 'description' => 'Lemari aksen bergaya kontemporer dengan warna yang berani. Menjadi *focal point* yang menarik di ruangan Anda.'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                array_merge($product, ['rating' => 4.5, 'customizable' => false, 'base_price' => $product['price']])
            );
        }
    }
}
