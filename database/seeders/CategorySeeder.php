<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_en' => 'Wedding',
                'name_ku' => 'ئاهەنگی زەماوەند',
                'slug' => 'wedding',
            ],
            [
                'name_en' => 'Birthday',
                'name_ku' => 'لەدایکبوون',
                'slug' => 'birthday',
            ],
            [
                'name_en' => 'Funeral',
                'name_ku' => 'چوارەمین',
                'slug' => 'funeral',
            ],
            [
                'name_en' => 'Anniversary',
                'name_ku' => 'ساڵڕۆژ',
                'slug' => 'anniversary',
            ],
            [
                'name_en' => 'Congratulations',
                'name_ku' => 'پیرۆزبایی',
                'slug' => 'congratulations',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories seeded successfully!');
    }
}


