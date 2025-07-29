<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::transction(function() {
        
    for ($productCount = 1; $productCount <= 100; $productCount++) {

        $payload = [
            'name' => 'Product ' . $productCount,
            'slug' => 'product-' . $productCount,
            'seller_id' => \App\Models\User :: inRandomOrder()->first()->id,
            'category_id'=> \App\Models\User:: whereNotNull('parent_id')->inRandomOrder()->first()->id, // Assuming you have 10 sellers
            'description' => 'Description for product' . $productCount, '.Lorem Ipsum bla', 
            'stock' => rand(1, 100),
            'weight' => rand(1, 100),
            'length' => rand(1, 100),
            'width' => rand(1, 100),
            'height' => rand(1, 100),
            'video' => 'attachment.mp4',
            'price' => rand(10000, 100000),
            'image' => [
                'attachment1.jpg',
                'attachment2.jpg',
                'attachment3.jpg',
                'attachment4.jpg',
            ],

            'variations' => [
                [
                    'name' =>'Warna',
                    'values' => [
                        'Merah',
                        'Biru',
                        'Hijau',
                        'Kuning',
                    ]
                ],
                [
                    'name' => 'Ukuran',
                    'values' => [
                        'S',
                        'M',
                        'L',
                        'XL',
                    ]
                ],
            ],
            'reviews' => [ 
                [
                    'user_id'=> \App\Models\User::inRandomOrder()->first()->id,
                    'star_seller' => rand (1,5), 
                    'star_courier' => rand (1,5), 
                    'variation' => 'Warna: Hijau, Ukuran: XL',
                    'description' => 'Produk Bagus !',
                    'attachments' =>  [
                        'attachment1.jpg',
                        'attachment2.jpg',
                        'attachment3.jpg',
                        'attachment4.jpg',
                    ],
                    'show_username' => rand(0,1),
                ],
            ]
            ];

            $product = \App\Models\Product\Product::create([
                    'name' => $payload['name'],
                    'slug' => $payload['slug'],
                    'seller_id' => $payload['seller_id'],
                    'category_id' => $payload['category_id'],
                    'description' => $payload['description'],
                    'stock' => $payload['stock'],
                    'weight' => $payload['weight'],
                    'length' => $payload['length'],
                    'width' => $payload['width'],
                    'height' => $payload['height'],
                    'video' => $payload['video'],
                    'price' => $payload['price'],
            ]);

            shuffle($payload['images']);
                foreach ($payload['images'] as $image) {
                    $product->images()->create([
                        'image' => $image
                    ]);
                }
            
            shuffle($payload['variations']);
                foreach ($payload['variations'] as $variation) {
                    $product->variations()->create($variation);
                }
            
            shuffle($payload['reviews']);
                foreach ($payload['reviews'] as $review) {
                    $product->reviews()->create($review);
                }
        }
    });
    }
}
