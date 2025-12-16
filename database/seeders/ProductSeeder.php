<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            [
                'category_id' => $categories->where('slug', 'wedding')->first()->id,
                'name_en' => 'Elegant White Roses',
                'name_ku' => 'گوڵی سپی جوان',
                'description_en' => 'Beautiful white roses perfect for weddings. These elegant flowers symbolize purity and new beginnings.',
                'description_ku' => 'گوڵی سپی جوان کە گونجاوە بۆ ئاهەنگی زەماوەند. ئەم گوڵە جوانە نیشانەی پاکی و دەستپێکی نوێیە.',
                'price' => 49.99,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'category_id' => $categories->where('slug', 'wedding')->first()->id,
                'name_en' => 'Romantic Red Rose Bouquet',
                'name_ku' => 'دەستە گوڵی سوور',
                'description_en' => 'A stunning bouquet of fresh red roses, perfect for expressing love and romance.',
                'description_ku' => 'دەستە گوڵێکی جوان لە گوڵی سووری تازە، گونجاوە بۆ دەربڕینی خۆشەویستی.',
                'price' => 39.99,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'category_id' => $categories->where('slug', 'birthday')->first()->id,
                'name_en' => 'Colorful Birthday Mix',
                'name_ku' => 'تێکەڵەی ڕەنگاوڕەنگی لەدایکبوون',
                'description_en' => 'A vibrant mix of colorful flowers to brighten any birthday celebration.',
                'description_ku' => 'تێکەڵەیەکی جوان لە گوڵی ڕەنگاوڕەنگ بۆ ڕۆشنکردنەوەی هەر ئاهەنگێکی لەدایکبوون.',
                'price' => 29.99,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'category_id' => $categories->where('slug', 'birthday')->first()->id,
                'name_en' => 'Sunny Sunflower Bouquet',
                'name_ku' => 'دەستە گوڵی خۆرەتاو',
                'description_en' => 'Bright and cheerful sunflowers to bring joy to any birthday.',
                'description_ku' => 'گوڵی خۆرەتاوی گەش و خۆش بۆ هێنانی خۆشی بۆ هەر لەدایکبوونێک.',
                'price' => 34.99,
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'category_id' => $categories->where('slug', 'funeral')->first()->id,
                'name_en' => 'Peaceful White Lilies',
                'name_ku' => 'گوڵی سپی ئارام',
                'description_en' => 'Serene white lilies to express sympathy and remembrance.',
                'description_ku' => 'گوڵی سپی ئارام بۆ دەربڕینی هاوسۆزی و یادکردنەوە.',
                'price' => 44.99,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories->where('slug', 'funeral')->first()->id,
                'name_en' => 'Sympathy Arrangement',
                'name_ku' => 'ڕێکخستنی هاوسۆزی',
                'description_en' => 'A respectful arrangement of flowers to honor loved ones.',
                'description_ku' => 'ڕێکخستنێکی ڕێزدارانە لە گوڵەکان بۆ ڕێزگرتن لە خۆشەویستان.',
                'price' => 54.99,
                'stock' => 12,
                'is_active' => true,
            ],
            [
                'category_id' => $categories->where('slug', 'anniversary')->first()->id,
                'name_en' => 'Anniversary Rose Collection',
                'name_ku' => 'کۆمەڵە گوڵی ساڵڕۆژ',
                'description_en' => 'A beautiful collection of roses to celebrate your special anniversary.',
                'description_ku' => 'کۆمەڵەیەکی جوان لە گوڵەکان بۆ پیرۆزبایی ساڵڕۆژی تایبەتت.',
                'price' => 59.99,
                'stock' => 18,
                'is_active' => true,
            ],
            [
                'category_id' => $categories->where('slug', 'anniversary')->first()->id,
                'name_en' => 'Romantic Orchids',
                'name_ku' => 'گوڵی ئۆرکید',
                'description_en' => 'Exotic orchids symbolizing love and luxury for anniversaries.',
                'description_ku' => 'گوڵی ئۆرکیدی نامۆ کە نیشانەی خۆشەویستی و لوکسە بۆ ساڵڕۆژەکان.',
                'price' => 69.99,
                'stock' => 10,
                'is_active' => true,
            ],
            [
                'category_id' => $categories->where('slug', 'congratulations')->first()->id,
                'name_en' => 'Success Celebration Bouquet',
                'name_ku' => 'دەستە گوڵی سەرکەوتن',
                'description_en' => 'A grand bouquet to celebrate achievements and success.',
                'description_ku' => 'دەستە گوڵێکی گەورە بۆ پیرۆزبایی بەدەستهێنانەکان و سەرکەوتن.',
                'price' => 45.99,
                'stock' => 22,
                'is_active' => true,
            ],
            [
                'category_id' => $categories->where('slug', 'congratulations')->first()->id,
                'name_en' => 'Bright Gerbera Mix',
                'name_ku' => 'تێکەڵەی گوڵی گێربێرا',
                'description_en' => 'Colorful gerbera daisies to congratulate and bring joy.',
                'description_ku' => 'گوڵی گێربێرای ڕەنگاوڕەنگ بۆ پیرۆزبایی و هێنانی خۆشی.',
                'price' => 32.99,
                'stock' => 28,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Products seeded successfully!');
    }
}


