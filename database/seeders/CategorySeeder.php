<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
            'name' => 'Electronics',
            'icon' => 'category/Elektronik.webp',
            'childs' => ['Microwave', 'TV',],
            ],
            [
            'name' => 'Handphone',
            'icon' => 'category/Handphone.webp',
            'childs' => ['Handphone', 'Anti Gores'],
            ],
            [
            'name' => 'Komputer & Laptop',
            'icon' => 'category/Komputer-Laptop.webp',
            'childs' => ['Keyboard', 'Laptop'],
            ],
            [
            'name' => 'Makanan & Minuman',
            'icon' => 'category/Makanan-Minuman.webp',
            'childs' => ['Makanan', 'Minuman'],
            ],
        ];

        foreach ($categories as $categoriesPayLoad) {
            $category = \App\Models\Category ::create([
                'name' => $categoriesPayLoad['name'],
                'slug' => \Str::slug($categoriesPayLoad['name']),
                'icon' => $categoriesPayLoad['icon'],
            ]);

            foreach ($categoryPayLoad['childs'] as $child) {
                $category->childs()->create([
                    'name' => $child,
                    'slug' => \Str::slug($child),
                ]);
            }
        }
    }
}
